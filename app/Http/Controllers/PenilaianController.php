<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PenilaianController extends Controller
{
    use AuthorizesRequests;
    public function index(Siswa $siswa)
    {
        $this->authorize('viewAny', [Penilaian::class, $siswa]);
        $penilaians = $siswa->penilaians()->orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'desc')->get();

        return view('guru.penilaian.index', compact('siswa', 'penilaians'));
    }

    public function create(Siswa $siswa)
    {
        // Load user guru relationship
        $user = Auth::user();
        $user->load('guru.kelompokKelas');

        $this->authorize('create', [Penilaian::class, $siswa]);

        return view('guru.penilaian.create', compact('siswa'));
    }

    public function store(Request $request, Siswa $siswa)
    {
        // Load user guru relationship
        $user = Auth::user();
        $user->load('guru.kelompokKelas');

        $this->authorize('create', [Penilaian::class, $siswa]);

        // Standardize semester input
        $request->merge([
            'semester' => match ($request->input('semester')) {
                '1' => 'Ganjil',
                '2' => 'Genap',
                default => $request->input('semester'),
            }
        ]);

        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:1,2,Ganjil,Genap',
            'agama_budi_pekerti' => 'required|string',
            'jati_diri' => 'required|string',
            'literasi_sains' => 'required|string',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'tanpa_keterangan' => 'nullable|integer|min:0',
            'catatan_kesehatan' => 'nullable|string',
            'catatan_guru' => 'nullable|string',
            'ekstrakurikuler' => 'nullable|array',
            'ekstrakurikuler.*.nama' => 'required_with:ekstrakurikuler|string|max:255',
            'ekstrakurikuler.*.predikat' => 'required_with:ekstrakurikuler|string|max:255',
        ]);

        // Filter out any null entries from the dynamic fields
        if (isset($validated['ekstrakurikuler'])) {
            $validated['ekstrakurikuler'] = array_filter($validated['ekstrakurikuler'], function ($item) {
                return !empty($item['nama']);
            });
        }

        $siswa->penilaians()->create($validated);

        return redirect()->route('guru.siswa.penilaian.index', $siswa)->with('success', 'Rapor berhasil disimpan.');
    }

    public function edit(Penilaian $penilaian)
    {
        // Load relationships
        $user = Auth::user();
        $user->load('guru.kelompokKelas');
        $penilaian->load('siswa');

        $this->authorize('update', $penilaian);

        return view('guru.penilaian.edit', ['penilaian' => $penilaian]);
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        // Load relationships
        $user = Auth::user();
        $user->load('guru.kelompokKelas');
        $penilaian->load('siswa');

        $this->authorize('update', $penilaian);

        // Standardize semester input
        $request->merge([
            'semester' => match ($request->input('semester')) {
                '1' => 'Ganjil',
                '2' => 'Genap',
                default => $request->input('semester'),
            }
        ]);

        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:1,2,Ganjil,Genap',
            'agama_budi_pekerti' => 'required|string',
            'jati_diri' => 'required|string',
            'literasi_sains' => 'required|string',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'tanpa_keterangan' => 'nullable|integer|min:0',
            'catatan_kesehatan' => 'nullable|string',
            'catatan_guru' => 'nullable|string',
            'ekstrakurikuler' => 'nullable|array',
            'ekstrakurikuler.*.nama' => 'required_with:ekstrakurikuler|string|max:255',
            'ekstrakurikuler.*.predikat' => 'required_with:ekstrakurikuler|string|max:255',
        ]);

        // Filter out any null entries from the dynamic fields
        if (isset($validated['ekstrakurikuler'])) {
            $validated['ekstrakurikuler'] = array_filter($validated['ekstrakurikuler'], function ($item) {
                return !empty($item['nama']);
            });
        } else {
            $validated['ekstrakurikuler'] = null;
        }

        $penilaian->update($validated);

        return redirect()->route('guru.siswa.penilaian.index', $penilaian->siswa)->with('success', 'Rapor berhasil diperbarui.');
    }

    public function destroy(Penilaian $penilaian)
    {
        // Load relationships
        $user = Auth::user();
        $user->load('guru.kelompokKelas');
        $penilaian->load('siswa');

        $this->authorize('delete', $penilaian);
        $siswa = $penilaian->siswa;
        $penilaian->delete();

        return redirect()->route('guru.siswa.penilaian.index', $siswa)->with('success', 'Rapor berhasil dihapus.');
    }

    public function print(Penilaian $penilaian)
    {
        // Load relationships
        $user = Auth::user();
        $user->load('guru.kelompokKelas');
        $penilaian->load('siswa');

        $this->authorize('view', $penilaian);

        return view('guru.penilaian.print', ['penilaian' => $penilaian]);
    }
}