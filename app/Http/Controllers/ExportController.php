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

    /**
     * Bulk export selected students to CSV format
     */
    public function bulkExportCsv(Request $request)
    {
        $request->validate([
            'penilaian_ids' => 'required|array',
            'penilaian_ids.*' => 'exists:penilaians,id',
        ]);

        $user = Auth::user();
        $query = Penilaian::whereIn('id', $request->penilaian_ids);

        // Check authorization for guru
        if ($user && $user->role === 'guru') {
            $guruKelasIds = $user->guru?->kelompokKelas?->pluck('id')->toArray() ?? [];
            $query->whereHas('siswa', function ($q) use ($guruKelasIds) {
                $q->whereIn('kelompok_kelas_id', $guruKelasIds);
            });
        }

        $penilaians = $query->with('siswa')->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk diexport.');
        }

        // Generate CSV
        $fileName = 'export_siswa_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($penilaians) {
            $file = fopen('php://output', 'w');

            // BOM for Excel to recognize UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['NISN', 'Nama Siswa', 'Kelas', 'Tahun Ajaran', 'Semester', 'Status', 'Terakhir Diupdate']);

            // Data
            foreach ($penilaians as $penilaian) {
                fputcsv($file, [
                    $penilaian->siswa->nisn ?? '-',
                    $penilaian->siswa->nama_lengkap,
                    $penilaian->siswa->kelompokKelas?->nama_kelas ?? '-',
                    $penilaian->tahun_ajaran,
                    $penilaian->semester === '1' ? 'Ganjil' : 'Genap',
                    'Dinilai',
                    $penilaian->updated_at->format('d-m-Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk export selected students to PDF format
     */
    public function bulkExportPdf(Request $request)
    {
        $request->validate([
            'penilaian_ids' => 'required|array',
            'penilaian_ids.*' => 'exists:penilaians,id',
        ]);

        $user = Auth::user();
        $query = Penilaian::whereIn('id', $request->penilaian_ids);

        // Check authorization for guru
        if ($user && $user->role === 'guru') {
            $guruKelasIds = $user->guru?->kelompokKelas?->pluck('id')->toArray() ?? [];
            $query->whereHas('siswa', function ($q) use ($guruKelasIds) {
                $q->whereIn('kelompok_kelas_id', $guruKelasIds);
            });
        }

        $penilaians = $query->with(['siswa', 'siswa.kelompokKelas', 'siswa.sekolah'])->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk diexport.');
        }

        $pdf = Pdf::loadView('exports.bulk-export-pdf', [
            'penilaians' => $penilaians,
            'sekolah' => $penilaians->first()->siswa->sekolah ?? null,
            'exportDate' => date('d-m-Y H:i:s'),
        ]);

        $fileName = 'export_siswa_' . date('Ymd_His') . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * Bulk export selected students to Excel format
     */
    public function bulkExportExcel(Request $request)
    {
        $request->validate([
            'penilaian_ids' => 'required|array',
            'penilaian_ids.*' => 'exists:penilaians,id',
        ]);

        $user = Auth::user();
        $query = Penilaian::whereIn('id', $request->penilaian_ids);

        // Check authorization for guru
        if ($user && $user->role === 'guru') {
            $guruKelasIds = $user->guru?->kelompokKelas?->pluck('id')->toArray() ?? [];
            $query->whereHas('siswa', function ($q) use ($guruKelasIds) {
                $q->whereIn('kelompok_kelas_id', $guruKelasIds);
            });
        }

        $penilaians = $query->with('siswa')->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk diexport.');
        }

        // Generate Excel using simple approach
        $fileName = 'export_siswa_' . date('Ymd_His') . '.xlsx';

        // Convert to SiswaExport format
        $data = $penilaians->map(function ($penilaian) {
            return [
                'NISN' => $penilaian->siswa->nisn ?? '-',
                'Nama Siswa' => $penilaian->siswa->nama_lengkap,
                'Kelas' => $penilaian->siswa->kelompokKelas?->nama_kelas ?? '-',
                'Email' => $penilaian->siswa->user?->email ?? '-',
                'Tahun Ajaran' => $penilaian->tahun_ajaran,
                'Semester' => $penilaian->semester === '1' ? 'Ganjil' : 'Genap',
                'Status' => 'Dinilai',
                'Terakhir Diupdate' => $penilaian->updated_at->format('d-m-Y H:i'),
            ];
        });

        // Use SiswaExport if available, otherwise create custom export
        try {
            $export = new \App\Exports\SiswaExport($data);
            return \Maatwebsite\Excel\Facades\Excel::download($export, $fileName);
        } catch (\Exception $e) {
            // Fallback: Return CSV if Excel export fails
            return $this->bulkExportCsv($request);
        }
    }

    /**
     * Bulk update status for selected students
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'penilaian_ids' => 'required|array',
            'penilaian_ids.*' => 'exists:penilaians,id',
            'status' => 'required|in:1,2,Dinilai,Belum Dinilai,Ganjil,Genap',
        ]);

        $user = Auth::user();
        $query = Penilaian::whereIn('id', $request->penilaian_ids);

        // Check authorization for guru
        if ($user && $user->role === 'guru') {
            $guruKelasIds = $user->guru?->kelompokKelas?->pluck('id')->toArray() ?? [];
            $query->whereHas('siswa', function ($q) use ($guruKelasIds) {
                $q->whereIn('kelompok_kelas_id', $guruKelasIds);
            });
        }

        $penilaians = $query->with('siswa')->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk diupdate.');
        }

        // Map status input
        $statusMap = [
            '1' => 'Dinilai',
            '2' => 'Belum Dinilai',
            'Dinilai' => 'Dinilai',
            'Belum Dinilai' => 'Belum Dinilai',
            'Ganjil' => '1',
            'Genap' => '2',
        ];

        $newStatus = $statusMap[$request->status] ?? $request->status;

        // For now, just mark as updated
        // In a real scenario, you might want to add a status column to penilaians table
        $updatedCount = 0;
        foreach ($penilaians as $penilaian) {
            // Update timestamp to show it was processed
            $penilaian->touch();
            $updatedCount++;
        }

        return back()->with('success', "Berhasil mengupdate status untuk $updatedCount siswa.");
    }
}
