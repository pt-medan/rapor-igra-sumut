<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\KelompokKelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class AdminProvinsiController extends Controller
{
    public function dashboard()
    {
        // Basic Stats
        $jumlahSekolah = Sekolah::count();
        $sekolahAktif = Sekolah::whereHas('gurus')->count();
        $jumlahGuru = Guru::count();
        $jumlahSiswa = Siswa::count();
        $jumlahPengguna = User::count();
        $pengguna_aktif = User::where('status', 'active')->count();
        $pending_users = User::where('status', 'pending')->count();

        // Trend data (last 30 days)
        $guru_trend = Guru::whereDate('created_at', '>=', now()->subDays(30))->count();
        $siswa_trend = Siswa::whereDate('created_at', '>=', now()->subDays(30))->count();

        // Top schools by student count
        $top_schools = Sekolah::withCount('siswas')
            ->orderBy('siswas_count', 'desc')
            ->limit(5)
            ->get();

        // Schools by status
        $sekolah_dengan_guru = Sekolah::whereHas('gurus')->count();
        $sekolah_tanpa_guru = $jumlahSekolah - $sekolah_dengan_guru;

        // Recent pending users
        $pending_users_list = User::where('status', 'pending')
            ->with(['sekolah', 'kelompokKelas'])
            ->latest()
            ->limit(5)
            ->get();

        // Recent activity (last validated users)
        $recent_activity = User::where('status', 'active')
            ->whereNotNull('validated_at')
            ->with(['sekolah'])
            ->latest('validated_at')
            ->limit(5)
            ->get();

        return view('admin.provinsi.dashboard', compact(
            'jumlahSekolah',
            'sekolahAktif',
            'jumlahGuru',
            'jumlahSiswa',
            'jumlahPengguna',
            'pengguna_aktif',
            'pending_users',
            'guru_trend',
            'siswa_trend',
            'top_schools',
            'sekolah_dengan_guru',
            'sekolah_tanpa_guru',
            'pending_users_list',
            'recent_activity'
        ));
    }

    public function userManagement(Request $request)
    {
        $query = User::where('id', '!=', Auth::id())
            ->with(['sekolah', 'kelompokKelas']);

        // Search by name or email
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by role
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15);

        $pending_count = User::where('status', 'pending')->count();
        $active_count = User::where('status', 'active')->count();

        return view('admin.provinsi.users', compact('users', 'pending_count', 'active_count'));
    }

    /**
     * School Management - List all schools
     */
    public function schools(Request $request)
    {
        $query = Sekolah::withCount(['gurus', 'siswas', 'kelompokKelas'])
            ->with('gurus');

        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_sekolah', 'like', '%' . $request->search . '%')
                ->orWhere('kota', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'active') {
                $query->has('gurus');
            } else {
                $query->doesntHave('gurus');
            }
        }

        $schools = $query->latest()->paginate(20);
        $total_gurus = Guru::count();
        $total_siswa = Siswa::count();

        return view('admin.provinsi.schools', compact('schools', 'total_gurus', 'total_siswa'));
    }

    /**
     * View school detail
     */
    public function schoolDetail(Sekolah $sekolah)
    {
        $sekolah->load(['gurus.user', 'siswas', 'kelompokKelas']);
        $stats = [
            'guru_count' => $sekolah->gurus->count(),
            'siswa_count' => $sekolah->siswas->count(),
            'kelas_count' => $sekolah->kelompokKelas->count(),
        ];

        return view('admin.provinsi.school-detail', compact('sekolah', 'stats'));
    }

    public function validateUser(User $user, Request $request)
    {
        // Validate student quota input for guru
        $validated = [];
        if ($user->role === 'guru') {
            $validated = $request->validate([
                'student_quota' => 'required|integer|min:1|max:1000',
            ]);
        }

        if ($user->role === 'guru') {
            // Get or create guru record - guru should already exist from registration
            $guru = $user->guru;
            if (!$guru) {
                // Fallback: create if it doesn't exist
                $guru = $user->guru()->create([
                    'nama_guru' => $user->name,
                    'sekolah_id' => $user->sekolah_id,
                    'student_quota' => $validated['student_quota'] ?? 30,
                ]);
            } else {
                // Just update the quota
                $guru->update([
                    'student_quota' => $validated['student_quota'] ?? 30,
                ]);
            }
        }

        // Finalize user validation status.
        $user->status = 'active';
        $user->validated_at = now();
        $user->validated_by = auth()->id();
        $user->save();

        return redirect()->route('admin.provinsi.users.index')->with('success', 'User berhasil divalidasi. Kuota siswa: ' . ($validated['student_quota'] ?? 30));
    }

    public function deactivateUser(User $user)
    {
        $user->status = 'pending';
        $user->validated_at = null;
        $user->validated_by = null;
        $user->save();

        return redirect()->route('admin.provinsi.users.index')->with('success', 'User berhasil dinonaktifkan.');
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'guru' && $user->guru) {
            $kelas = KelompokKelas::where('guru_id', $user->guru->id)->first();
            if ($kelas) {
                $kelas->guru_id = null;
                $kelas->save();
            }
        }

        $user->delete();

        return redirect()->route('admin.provinsi.users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Manage guru student quota
     */
    public function guruQuotaManagement(Request $request)
    {
        $query = Guru::with(['user', 'sekolah']);

        // Search by guru name or email
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by school
        if ($request->has('sekolah_id') && !empty($request->sekolah_id)) {
            $query->where('sekolah_id', $request->sekolah_id);
        }

        $gurus = $query->latest()->paginate(20);
        $schools = Sekolah::orderBy('nama_sekolah')->get();

        return view('admin.provinsi.guru-quota', compact('gurus', 'schools'));
    }

    /**
     * Update guru student quota
     */
    public function updateGuruQuota(Guru $guru, Request $request)
    {
        $validated = $request->validate([
            'student_quota' => 'required|integer|min:0|max:1000',
        ]);

        $guru->update([
            'student_quota' => $validated['student_quota'],
        ]);

        return redirect()->back()->with('success', "Kuota siswa untuk {$guru->nama_guru} berhasil diperbarui.");
    }
}