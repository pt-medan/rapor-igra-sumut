<?php

namespace App\Http\Controllers;

use App\Models\KelompokKelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Imports\SiswaImport;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Auth::user()->guru;

        if (!$guru) {
            // Redirect or show an error if the user is not a guru
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar sebagai guru.');
        }

        // Eager load the kelompokKelas relationship
        $guru->load('kelompokKelas.siswas');

        $kelas = $guru->kelompokKelas;
        $siswas = $kelas ? $kelas->siswas : collect();

        return view('guru.siswa.index', compact('guru', 'kelas', 'siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        \Log::info('SiswaController@create: User ID - ' . $user->id . ', User Role - ' . $user->role . ', User Sekolah ID - ' . $user->sekolah_id);

        $kelompokKelas = KelompokKelas::where('sekolah_id', $user->sekolah_id)->get();
        \Log::info('SiswaController@create: Kelompok Kelas retrieved - ' . $kelompokKelas->count());

        return view('guru.siswa.create', compact('kelompokKelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $guru = $user->guru;
        $sekolahId = $user->sekolah_id;

        // Check if guru has quota
        if (!$guru || $guru->student_quota <= 0) {
            return redirect()->back()->with('error', 'Anda belum memiliki kuota siswa. Hubungi admin provinsi untuk mendapatkan kuota.');
        }

        // Check if guru has reached quota limit
        if ($guru->student_count >= $guru->student_quota) {
            return redirect()->back()->with('error', "Anda telah mencapai batas kuota siswa ({$guru->student_quota}). Hubungi admin provinsi untuk menambah kuota.");
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('siswas')->where('sekolah_id', $sekolahId)],
            'kelompok_kelas_id' => ['required', Rule::exists('kelompok_kelas', 'id')->where('sekolah_id', $sekolahId)],
            // Add other fields as necessary
        ]);

        Siswa::create($request->all() + ['sekolah_id' => $sekolahId]);

        // Increment student count
        $guru->increment('student_count');

        return redirect()->route('guru.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        if ($siswa->sekolah_id !== Auth::user()->sekolah_id) {
            abort(403);
        }
        $kelompokKelas = KelompokKelas::where('sekolah_id', Auth::user()->sekolah_id)->get();

        return view('guru.siswa.edit', compact('siswa', 'kelompokKelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        if ($siswa->sekolah_id !== Auth::user()->sekolah_id) {
            abort(403);
        }

        $sekolahId = Auth::user()->sekolah_id;
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('siswas')->where('sekolah_id', $sekolahId)->ignore($siswa->id)],
            'kelompok_kelas_id' => ['required', Rule::exists('kelompok_kelas', 'id')->where('sekolah_id', $sekolahId)],
        ]);

        $siswa->update($request->all());

        return redirect()->route('guru.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        if ($siswa->sekolah_id !== Auth::user()->sekolah_id) {
            abort(403);
        }

        $guru = Auth::user()->guru;
        $siswa->delete();

        // Decrement student count
        if ($guru) {
            $guru->decrement('student_count');
        }

        return redirect()->route('guru.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Show the form for importing students.
     */
    public function showImportForm()
    {
        return view('guru.siswa.import');
    }

    /**
     * Store imported students.
     */
    public function storeImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        $guru = Auth::user()->guru;

        // Check if guru has quota
        if (!$guru || $guru->student_quota <= 0) {
            return redirect()->back()->with('error', 'Anda belum memiliki kuota siswa. Hubungi admin provinsi untuk mendapatkan kuota.');
        }

        try {
            Excel::import(new SiswaImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return back()->withErrors($errorMessages);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage()]);
        }

        return redirect()->route('guru.siswa.index')->with('success', 'Siswa berhasil diimpor.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\SiswaTemplateExport, 'template_siswa.xlsx');
    }

    public function exportSiswa()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru?->kelompokKelas;

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas untuk diekspor.');
        }

        return Excel::download(new SiswaExport($kelas->id), 'siswa_' . $kelas->nama_kelompok . '.xlsx');
    }
}
