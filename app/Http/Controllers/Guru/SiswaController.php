<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\KelompokKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SiswaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Check if the authenticated user is authorized to manage the student.
     */
    private function authorizeSiswa(Siswa $siswa)
    {
        // Ensure user and relationships are loaded fresh from database
        $user = Auth::user()->fresh()->load(['guru.sekolah', 'guru.kelompokKelas']);
        $guru = $user->guru;

        // Check 1: User must be a guru with a profile
        if (!$guru) {
            abort(403, 'AKSES DITOLAK: Anda tidak memiliki profil guru.');
        }

        // Check 2: Guru must be assigned to a class
        if (!$guru->kelompokKelas) {
            abort(403, 'AKSES DITOLAK: Anda tidak ditugaskan ke kelompok kelas mana pun.');
        }

        // Check 3: Student must be in the same class as the guru (use == for loose comparison)
        if ((int) $siswa->kelompok_kelas_id != (int) $guru->kelompokKelas->id) {
            abort(403, 'AKSES DITOLAK: Siswa ini bukan di kelas Anda.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ensure guru and kelas are loaded fresh from database
        $user = Auth::user()->fresh()->load(['guru.kelompokKelas']);

        $guru = $user->guru;

        // Validate that user has a guru profile
        if (!$guru) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda tidak terdaftar sebagai guru. Hubungi admin untuk mendaftarkan akun guru Anda.');
        }

        $kelas = $guru ? $guru->kelompokKelas : null;

        // Eager load the 'penilaians' relationship
        $siswas = $kelas ? $kelas->siswas()->with('penilaians')->get() : collect();

        return view('guru.siswa.index', compact('siswas', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ensure guru and kelas are loaded fresh from database
        $user = Auth::user()->fresh()->load(['guru.kelompokKelas']);

        $guru = $user->guru;

        // Validate that user has a guru profile
        if (!$guru) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda tidak terdaftar sebagai guru. Hubungi admin untuk mendaftarkan akun guru Anda.');
        }

        $kelompokKelas = $guru && $guru->kelompokKelas ? [$guru->kelompokKelas] : [];

        if (empty($kelompokKelas)) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda tidak ditugaskan ke kelompok kelas mana pun.');
        }

        // Calculate quota information
        $kelas = $kelompokKelas[0] ?? null;
        $siswaCount = $kelas ? $kelas->siswas()->count() : 0;
        $quotaInfo = [
            'quota' => $guru->student_quota,
            'used' => $siswaCount,
            'remaining' => $guru->student_quota > 0 ? max(0, $guru->student_quota - $siswaCount) : -1,
            'is_unlimited' => $guru->student_quota <= 0,
            'is_full' => $guru->student_quota > 0 && $siswaCount >= $guru->student_quota,
        ];

        return view('guru.siswa.create', compact('kelompokKelas', 'quotaInfo', 'guru'));
    }

    /**
     * Check student quota via AJAX
     */
    public function checkQuota()
    {
        $user = Auth::user()->fresh()->load(['guru.kelompokKelas']);
        $guru = $user->guru;
        $kelompokKelas = $guru ? $guru->kelompokKelas : null;

        if (!$guru || !$kelompokKelas) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak ditugaskan ke kelompok kelas mana pun.',
            ]);
        }

        $siswaCount = $kelompokKelas->siswas()->count();
        $quota = $guru->student_quota;
        $isUnlimited = $quota <= 0;
        $isFull = $quota > 0 && $siswaCount >= $quota;

        return response()->json([
            'success' => true,
            'quota' => $quota,
            'used' => $siswaCount,
            'remaining' => $isUnlimited ? -1 : max(0, $quota - $siswaCount),
            'is_unlimited' => $isUnlimited,
            'is_full' => $isFull,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure guru and kelas are loaded fresh from database
        $user = Auth::user()->fresh()->load(['guru.kelompokKelas']);

        $guru = $user->guru;

        // Validate that user has a guru profile
        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak terdaftar sebagai guru. Hubungi admin untuk mendaftarkan akun guru Anda.',
            ], 403);
        }

        $kelompokKelas = $guru ? $guru->kelompokKelas : null;

        if (!$kelompokKelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda tidak dapat menambahkan siswa karena tidak ditugaskan ke kelas mana pun.');
        }

        // CRITICAL: Validate that the submitted kelas belongs to this guru
        $requestedKelasId = $request->input('kelompok_kelas_id');
        if ($requestedKelasId && $requestedKelasId != $kelompokKelas->id) {
            abort(403, 'Anda tidak diizinkan menambah siswa di kelas ini. Anda hanya bisa menambah siswa di kelas Anda sendiri.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:255|unique:siswas,nisn',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
        ]);

        // Check student quota
        if ($guru->student_quota > 0) {
            $siswasInKelas = $kelompokKelas->siswas()->count();

            if ($siswasInKelas >= $guru->student_quota) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Kuota siswa penuh! Anda telah mencapai batas maksimal ' . $guru->student_quota . ' siswa. Silakan hubungi admin provinsi untuk meningkatkan kuota siswa Anda.',
                ], 422);
            }
        }

        $siswa = new Siswa($request->all());
        $siswa->kelompok_kelas_id = $kelompokKelas->id;
        $siswa->sekolah_id = $kelompokKelas->sekolah_id;
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil ditambahkan.',
            'redirect' => route('guru.siswa.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        // Pastikan guru hanya bisa melihat siswa di kelasnya
        $this->authorizeSiswa($siswa);
        $penilaians = $siswa->penilaians()->orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'desc')->get();

        return view('guru.siswa.show', compact('siswa', 'penilaians'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $this->authorizeSiswa($siswa);

        // Ensure guru and kelas are loaded fresh from database
        $user = Auth::user()->fresh()->load(['guru.kelompokKelas']);
        $guru = $user->guru;
        $kelompokKelas = $guru && $guru->kelompokKelas ? [$guru->kelompokKelas] : [];

        return view('guru.siswa.edit', compact('siswa', 'kelompokKelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $this->authorizeSiswa($siswa);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:255|unique:siswas,nisn,' . $siswa->id,
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
        ]);

        $siswa->update($request->all());

        return redirect()->route('guru.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $this->authorizeSiswa($siswa);

        // Decrement student count from guru's quota
        $user = Auth::user();
        if ($user->guru) {
            $user->guru->decrement('student_count');
        }

        $siswa->delete();
        return redirect()->route('guru.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
