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
        // Step 1: Validate basic user details (always required)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:guru'],
        ]);

        $sekolahId = null;

        // Step 2: Handle School Registration / Selection with Enhanced Validation
        if ($request->has('register_new_school') && $request->register_new_school) {
            // Validasi untuk sekolah baru
            $request->validate([
                'nama_sekolah' => ['required', 'string', 'max:255'],
                'npsn' => ['required', 'string', 'max:20'],
                'provinsi' => ['required', 'string'],
                'kabupaten' => ['required', 'string'],
                'kepala_sekolah' => ['nullable', 'string', 'max:255'],
                'status_sekolah' => ['required', 'string', 'in:negeri,swasta'],
            ]);

            // Check if school with same name, provinsi, and kabupaten already exists
            $existingSekolah = Sekolah::where('nama_sekolah', $request->nama_sekolah)
                ->where('provinsi', $request->provinsi)
                ->where('kabupaten', $request->kabupaten)
                ->first();

            if ($existingSekolah) {
                return back()
                    ->withErrors(['nama_sekolah' => 'Sekolah dengan nama "' . $request->nama_sekolah . '" di ' . $request->kabupaten . ', ' . $request->provinsi . ' telah terdaftar.'])
                    ->withInput();
            }

            $sekolah = Sekolah::create($request->only(['nama_sekolah', 'npsn', 'alamat', 'provinsi', 'kabupaten', 'kepala_sekolah', 'status_sekolah']));
            $sekolahId = $sekolah->id;
        } else {
            // Validasi untuk sekolah yang sudah terdaftar
            $request->validate(['sekolah_id' => ['required', 'exists:sekolahs,id']]);
            $sekolahId = $request->sekolah_id;
        }

        // Step 3: Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'pending',
            'sekolah_id' => $sekolahId,
        ]);

        // Step 4: Handle Class Assignment for Guru Role
        if ($request->role === 'guru') {
            $guru = $user->guru()->create([
                'nama_guru' => $user->name,
                'sekolah_id' => $sekolahId,
            ]);

            // Validate that kelompok_kelas_id is provided
            $request->validate(['kelompok_kelas_id' => ['required']]);

            if ($request->kelompok_kelas_id === 'new_class') {
                // Validasi kelas baru
                $request->validate([
                    'nama_kelompok_kelas_baru' => ['required', 'string', 'max:255'],
                ]);

                $kelompokKelas = KelompokKelas::create([
                    'sekolah_id' => $sekolahId,
                    'guru_id' => $guru->id,
                    'nama_kelompok' => $request->nama_kelompok_kelas_baru,
                    'tahun_ajaran' => $request->input('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)),
                ]);

                $user->kelompok_kelas_id = $kelompokKelas->id;
                $user->save();
            } else {
                // Validasi kelas yang sudah ada
                $request->validate(['kelompok_kelas_id' => ['exists:kelompok_kelas,id']]);
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

        // Redirect to login with success message
        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu validasi dari admin provinsi. Silakan login kembali setelah akun Anda divalidasi.');
    }
}
