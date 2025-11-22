<?php

namespace App\Http\Controllers;

use App\Models\KelompokKelas;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function bulkPrintRapor(Request $request, KelompokKelas $kelompok_kelas)
    {
        $user = Auth::user();

        if ($user && $user->role === 'guru') {
            $guruKelompokKelas = $user->guru?->kelompokKelas;
            if (!$guruKelompokKelas || $guruKelompokKelas->id !== $kelompok_kelas->id) {
                abort(403, 'Anda tidak berhak mengakses rapor kelas ini.');
            }
        }

        $siswas = $kelompok_kelas->siswas;
        if ($siswas->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa di kelas ini untuk diekspor.');
        }

        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester');

        $semesterForQuery = null;
        if (strtolower($semester) === 'ganjil') {
            $semesterForQuery = '1';
        } elseif (strtolower($semester) === 'genap') {
            $semesterForQuery = '2';
        } else {
            $semesterForQuery = $semester;
        }

        $penilaiansQuery = Penilaian::whereIn('siswa_id', $siswas->pluck('id'))
            ->with(['siswa', 'siswa.kelompokKelas', 'siswa.sekolah']);

        if ($tahunAjaran) {
            $penilaiansQuery->whereRaw('TRIM(tahun_ajaran) = ?', [trim($tahunAjaran)]);
        }

        if ($semesterForQuery) {
            $penilaiansQuery->where('semester', $semesterForQuery);
        }

        $penilaians = $penilaiansQuery->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', "Tidak ada rapor yang ditemukan untuk filter yang dipilih.");
        }

        $pdf = Pdf::loadView('exports.rapor-bulk', ['penilaians' => $penilaians]);
        $safeTahunAjaran = $tahunAjaran ? ' - ' . str_replace('/', '-', $tahunAjaran) : '';
        $fileName = 'Rapor Massal - ' . $kelompok_kelas->nama_kelompok . $safeTahunAjaran . ($semester ? ' - ' . $semester : '') . '.pdf';

        return $pdf->stream($fileName);
    }

    public function bulkExportRapor(Request $request)
    {
        $request->validate([
            'siswas' => 'required|array',
            'siswas.*' => 'exists:siswas,id',
        ]);

        $user = Auth::user();

        if ($user && $user->role === 'guru') {
            $kelompokKelasIds = $user->guru?->kelompokKelas?->pluck('id')->toArray() ?? [];

            if (empty($kelompokKelasIds)) {
                abort(403, 'Anda tidak berhak export rapor.');
            }

            $siswas = Siswa::whereIn('id', $request->siswas)
                ->whereIn('kelompok_kelas_id', $kelompokKelasIds)
                ->get();

            if (count($siswas) !== count($request->siswas)) {
                abort(403, 'Beberapa siswa tidak valid untuk diexport.');
            }
        } else {
            $siswas = Siswa::whereIn('id', $request->siswas)->get();
        }

        $penilaians = Penilaian::whereIn('siswa_id', $siswas->pluck('id'))
            ->with(['siswa', 'siswa.kelompokKelas', 'siswa.sekolah'])
            ->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada rapor yang ditemukan untuk siswa yang dipilih.');
        }

        $pdf = Pdf::loadView('exports.rapor-bulk', ['penilaians' => $penilaians]);
        $fileName = 'Export Rapor ' . date('Y-m-d') . '.pdf';

        return $pdf->stream($fileName);
    }
}
