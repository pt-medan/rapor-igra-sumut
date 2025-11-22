<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\KelompokKelas;
use App\Models\User;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard(Request $request)
    {
        // Ensure guru is loaded fresh from database with relationships
        $user = Auth::user()->fresh()->load(['guru.kelompokKelas']);

        $guru = $user->guru;
        if (!$guru || !$guru->kelompokKelas) {
            return view('guru.dashboard-unassigned');
        }

        $kelas = $guru->kelompokKelas;
        $siswas = $kelas->siswas()->get();
        $sekolah = Auth::user()->sekolah;

        // Get all available academic years for the filter dropdown
        $availableTahunAjaran = Penilaian::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');

        // Determine the default academic period by querying the raw semester value
        $latestPenilaian = Penilaian::orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc') // Sorts based on stored value '2' (Genap) then '1' (Ganjil)
            ->first();

        // The accessor on the model will convert semester to 'Ganjil'/'Genap'
        $defaultTahunAjaran = $latestPenilaian ? $latestPenilaian->tahun_ajaran : null;
        $defaultSemester = $latestPenilaian ? $latestPenilaian->semester : null;

        // Determine the current period from request or fallback to the default
        $currentTahunAjaran = $request->input('tahun_ajaran', $defaultTahunAjaran);
        $currentSemester = $request->input('semester', $defaultSemester);

        // Convert the display semester back to its stored value for the query
        $semesterForQuery = null;
        if (strtolower($currentSemester) === 'ganjil') {
            $semesterForQuery = '1';
        } elseif (strtolower($currentSemester) === 'genap') {
            $semesterForQuery = '2';
        } else {
            $semesterForQuery = $currentSemester; // Fallback
        }

        // Get all penilaians for the students in this class for the selected period
        $penilaians = Penilaian::whereIn('siswa_id', $siswas->pluck('id'))
            ->when($currentTahunAjaran, function ($query, $tahunAjaran) {
                return $query->whereRaw('TRIM(tahun_ajaran) = ?', [trim($tahunAjaran)]);
            })
            ->when($semesterForQuery, function ($query, $semester) {
                return $query->where('semester', $semester);
            })
            ->get()
            ->keyBy('siswa_id');

        // Calculate stats
        $jumlahSiswa = $siswas->count();
        $jumlahDinilai = $penilaians->count();
        $jumlahBelumDinilai = $jumlahSiswa - $jumlahDinilai;

        // New enhanced stats
        $persentaseDinilai = $jumlahSiswa > 0 ? round(($jumlahDinilai / $jumlahSiswa) * 100) : 0;

        // Total penilaians (all periods)
        $totalPenilaians = Penilaian::whereIn('siswa_id', $siswas->pluck('id'))->count();

        // Recent penilaians (last 5)
        $recentPenilaians = Penilaian::whereIn('siswa_id', $siswas->pluck('id'))
            ->latest('updated_at')
            ->with(['siswa'])
            ->limit(5)
            ->get();

        // Penilaians by semester (for current tahun ajaran)
        $penilaiansByPeriod = Penilaian::whereIn('siswa_id', $siswas->pluck('id'))
            ->when($currentTahunAjaran, function ($query, $tahunAjaran) {
                return $query->whereRaw('TRIM(tahun_ajaran) = ?', [trim($tahunAjaran)]);
            })
            ->select('semester')
            ->distinct()
            ->count();

        // Students without any penilaians
        $siswaTanpaPenilaian = Penilaian::whereIn('siswa_id', $siswas->pluck('id'))->pluck('siswa_id');
        $siswaBelumDinilaiTotal = $siswas->whereNotIn('id', $siswaTanpaPenilaian)->count();

        // Student quota info
        $studentQuota = $guru->student_quota;
        $studentCount = $guru->student_count;
        $quotaRemaining = max(0, $studentQuota - $studentCount);
        $quotaPercentage = $studentQuota > 0 ? round(($studentCount / $studentQuota) * 100) : 0;

        return view('guru.dashboard', compact(
            'kelas',
            'siswas',
            'penilaians',
            'currentTahunAjaran',
            'currentSemester',
            'availableTahunAjaran',
            'jumlahSiswa',
            'jumlahDinilai',
            'jumlahBelumDinilai',
            'persentaseDinilai',
            'totalPenilaians',
            'recentPenilaians',
            'penilaiansByPeriod',
            'siswaBelumDinilaiTotal',
            'sekolah',
            'studentQuota',
            'studentCount',
            'quotaRemaining',
            'quotaPercentage'
        ));
    }

    public function raporIndex(Request $request)
    {
        $sekolah = Auth::user()->sekolah;
        if (!$sekolah) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar di sekolah manapun.');
        }
        $kelompokKelasList = KelompokKelas::where('sekolah_id', $sekolah->id)->orderBy('nama')->get();

        $penilaiansQuery = Penilaian::whereHas('siswa', function ($query) use ($sekolah) {
            $query->where('sekolah_id', $sekolah->id);
        })->with(['siswa', 'siswa.kelompokKelas'])->latest();

        // Filter by kelas
        if ($request->filled('kelompok_kelas_id')) {
            $penilaiansQuery->whereHas('siswa', function ($query) use ($request) {
                $query->where('kelompok_kelas_id', $request->kelompok_kelas_id);
            });
        }

        // Search by student name
        if ($request->filled('search')) {
            $penilaiansQuery->whereHas('siswa', function ($query) use ($request) {
                $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $penilaians = $penilaiansQuery->paginate(20);

        return view('guru.rapor.index', compact('penilaians', 'kelompokKelasList'));
    }

    public function editSekolah()
    {
        $sekolah = Auth::user()->sekolah;
        return view('guru.sekolah.edit', compact('sekolah'));
    }

    public function updateSekolah(Request $request)
    {
        $sekolah = Auth::user()->sekolah;

        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'npsn' => 'required|string|max:20',
            'kepala_sekolah' => 'nullable|string|max:255',
            'status' => 'required|in:negeri,swasta',
        ]);

        $sekolah->update($request->all());

        return redirect()->route('guru.sekolah.edit')->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    public function kelompokKelasIndex()
    {
        $kelompokKelas = KelompokKelas::where('sekolah_id', Auth::user()->sekolah_id)->with('waliKelas.user')->get();
        return view('guru.kelompok-kelas.index', compact('kelompokKelas'));
    }

    public function siswaIndex()
    {
        $siswas = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->with('kelompokKelas')->get();
        return view('guru.siswa.index-sekolah', compact('siswas'));
    }

    public function tetapkanKelas(Request $request, Siswa $siswa)
    {
        // Logika untuk penetapan kelas mandiri oleh guru
    }
}
