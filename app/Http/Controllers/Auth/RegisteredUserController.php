<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KelompokKelas;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $sekolahs = Sekolah::all();

        return view('auth.register', compact('sekolahs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:guru'],
        ]);

        $sekolahId = null;

        // Handle School Registration
        if ($request->has('register_new_school')) {
            $request->validate([
                'nama_sekolah' => ['required', 'string', 'max:255', 'unique:sekolahs,nama_sekolah'],
                'npsn' => ['required', 'string', 'max:20', 'unique:sekolahs,npsn'],
                // Add other school fields validation as needed
            ]);
            $sekolah = Sekolah::create($request->only(['nama_sekolah', 'npsn', 'alamat', 'provinsi', 'kabupaten', 'kepala_sekolah', 'status_sekolah']));
            $sekolahId = $sekolah->id;
        } else {
            $request->validate(['sekolah_id' => ['required', 'exists:sekolahs,id']]);
            $sekolahId = $request->sekolah_id;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'pending', // Set status to pending for validation
            'sekolah_id' => $sekolahId,
        ]);

        if ($request->role === 'guru') {
            $guru = $user->guru()->create([
                'nama_guru' => $user->name,
                'sekolah_id' => $sekolahId,
            ]);

            if ($request->kelompok_kelas_id === 'new_class') {
                $request->validate([
                    'nama_kelompok_kelas_baru' => ['required', 'string', 'max:255'],
                ]);

                $kelompokKelas = KelompokKelas::create([
                    'sekolah_id' => $sekolahId,
                    'guru_id' => $guru->id,
                    'nama_kelompok' => $request->nama_kelompok_kelas_baru,
                    'tahun_ajaran' => $request->input('tahun_ajaran', '2025/2026'), // Ensure tahun_ajaran is always set
                ]);

                $user->kelompok_kelas_id = $kelompokKelas->id;
                $user->save();
            } else {
                $request->validate(['kelompok_kelas_id' => ['required', 'exists:kelompok_kelas,id']]);
                $user->kelompok_kelas_id = $request->kelompok_kelas_id;
                $user->save();

                $kelas = KelompokKelas::find($request->kelompok_kelas_id);
                if ($kelas) {
                    $kelas->guru_id = $guru->id;
                    $kelas->save();
                }
            }
        }

        event(new Registered($user));

        // Don't auto-login pending guru, redirect to pending page with message
        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu validasi dari admin provinsi. Silakan login kembali setelah akun Anda divalidasi.');
    }
}
