<?php

namespace App\Http\Controllers;

use App\Models\KelompokKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelompokKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompokKelas = KelompokKelas::where('sekolah_id', Auth::user()->sekolah_id)->with('waliKelas.user')->get();

        return view('guru.kelompok-kelas.index', compact('kelompokKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.kelompok-kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
        ]);

        KelompokKelas::create([
            'nama_kelompok' => $request->nama_kelompok,
            'tahun_ajaran' => '2025/2026',
            'sekolah_id' => Auth::user()->sekolah_id,
        ]);

        return redirect()->route('guru.kelompok-kelas.index')->with('success', 'Kelompok kelas berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelompokKelas $kelompokKela)
    {
        // Authorization check
        if ($kelompokKela->sekolah_id !== Auth::user()->sekolah_id) {
            abort(403);
        }

        return view('guru.kelompok-kelas.edit', ['kelompokKelas' => $kelompokKela]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KelompokKelas $kelompokKela)
    {
        // Authorization check
        if ($kelompokKela->sekolah_id !== Auth::user()->sekolah_id) {
            abort(403);
        }

        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
        ]);

        $kelompokKela->update($request->all());

        return redirect()->route('guru.kelompok-kelas.index')->with('success', 'Kelompok kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KelompokKelas $kelompokKela)
    {
        // Authorization check
        if ($kelompokKela->sekolah_id !== Auth::user()->sekolah_id) {
            abort(403);
        }

        $kelompokKela->delete();

        return redirect()->route('guru.kelompok-kelas.index')->with('success', 'Kelompok kelas berhasil dihapus.');
    }
}
