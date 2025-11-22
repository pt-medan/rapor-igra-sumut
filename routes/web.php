<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    switch ($role) {
        case 'admin_provinsi':
            return redirect()->route('admin.provinsi.dashboard');
        case 'guru':
            // Check if guru is validated before redirecting
            if (auth()->user()->status !== 'active') {
                \Illuminate\Support\Facades\Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun guru Anda belum divalidasi oleh admin provinsi. Silakan tunggu persetujuan dari admin.');
            }
            return redirect()->route('guru.dashboard');
        default:
            abort(403, 'Unauthorized role');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Route to get kelas list for registration form
Route::get('/api/sekolah/{sekolah}/kelas', [App\Http\Controllers\Api\KelompokKelasController::class, 'getBySekolah'])->name('api.sekolah.kelas');

// Admin Provinsi Routes
Route::middleware(['auth', 'role:admin_provinsi'])->prefix('admin/provinsi')->name('admin.provinsi.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\AdminProvinsiController::class, 'dashboard'])->name('dashboard');
    Route::get('users', [App\Http\Controllers\AdminProvinsiController::class, 'userManagement'])->name('users.index');
    Route::post('users/{user}/validate', [App\Http\Controllers\AdminProvinsiController::class, 'validateUser'])->name('users.validate');
    Route::post('users/{user}/deactivate', [App\Http\Controllers\AdminProvinsiController::class, 'deactivateUser'])->name('users.deactivate');
    Route::delete('users/{user}', [App\Http\Controllers\AdminProvinsiController::class, 'destroyUser'])->name('users.destroy');
    Route::get('schools', [App\Http\Controllers\AdminProvinsiController::class, 'schools'])->name('schools.index');
    Route::get('schools/{sekolah}', [App\Http\Controllers\AdminProvinsiController::class, 'schoolDetail'])->name('schools.detail');
    Route::get('guru-quota', [App\Http\Controllers\AdminProvinsiController::class, 'guruQuotaManagement'])->name('guru.quota.index');
    Route::patch('guru/{guru}/quota', [App\Http\Controllers\AdminProvinsiController::class, 'updateGuruQuota'])->name('guru.quota.update');
});

// Admin Website Routes - for managing website content
Route::middleware(['auth', 'role:admin_provinsi'])->prefix('admin/website')->name('admin-website.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminWebsiteController::class, 'index'])->name('index');
    Route::get('/edit', [App\Http\Controllers\AdminWebsiteController::class, 'edit'])->name('edit');
    Route::put('/', [App\Http\Controllers\AdminWebsiteController::class, 'update'])->name('update');
    Route::get('/statistics', [App\Http\Controllers\AdminWebsiteController::class, 'getStatistics'])->name('statistics');
});

// Guru Routes
Route::middleware(['auth', 'role:guru', 'guru.verified'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\GuruController::class, 'dashboard'])->name('dashboard');
    Route::resource('kelompok-kelas', App\Http\Controllers\KelompokKelasController::class);
    Route::get('guru', [App\Http\Controllers\GuruController::class, 'index'])->name('guru.index');
    Route::post('guru/assign', [App\Http\Controllers\GuruController::class, 'assignWaliKelas'])->name('guru.assign');
    Route::get('siswa/import', [App\Http\Controllers\SiswaController::class, 'showImportForm'])->name('siswa.import.show');
    Route::get('siswa/import/template', [App\Http\Controllers\SiswaController::class, 'downloadTemplate'])->name('siswa.import.template');
    Route::get('siswa/export', [App\Http\Controllers\SiswaController::class, 'exportSiswa'])->name('siswa.export');
    Route::post('siswa/import', [App\Http\Controllers\SiswaController::class, 'storeImport'])->name('siswa.import.store');
    Route::get('siswa/check-quota', [App\Http\Controllers\Guru\SiswaController::class, 'checkQuota'])->name('siswa.check-quota');
    Route::resource('siswa', App\Http\Controllers\Guru\SiswaController::class)->except(['show']);
    Route::get('rapor', [App\Http\Controllers\GuruController::class, 'raporIndex'])->name('rapor.index');
    Route::get('penilaian/{penilaian}/print', [App\Http\Controllers\PenilaianController::class, 'print'])->name('penilaian.print');
    Route::get('export/kelompok-kelas/{kelompok_kelas}/pdf', [App\Http\Controllers\ExportController::class, 'bulkPrintRapor'])->name('export.rapor.kelas');
    Route::post('export/rapor/massal', [App\Http\Controllers\ExportController::class, 'bulkExportRapor'])->name('export.rapor.massal');
    Route::resource('siswa.penilaian', App\Http\Controllers\PenilaianController::class)->shallow()->except(['show']);
    Route::get('sekolah/edit', [App\Http\Controllers\GuruController::class, 'editSekolah'])->name('sekolah.edit');
    Route::patch('sekolah', [App\Http\Controllers\GuruController::class, 'updateSekolah'])->name('sekolah.update');
});

// DEBUG ROUTES - Remove after testing
Route::get('/debug/user-check', function () {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }

    $user = auth()->user()->load(['guru.kelompokKelas', 'guru.sekolah']);

    return response()->json([
        'user_id' => $user->id,
        'email' => $user->email,
        'role' => $user->role,
        'status' => $user->status,
        'guru_loaded' => $user->guru ? true : false,
        'guru_id' => $user->guru?->id,
        'guru_sekolah_id' => $user->guru?->sekolah_id,
        'guru_nama' => $user->guru?->nama_guru,
        'kelompok_kelas_loaded' => $user->guru?->kelompokKelas ? true : false,
        'kelompok_kelas_id' => $user->guru?->kelompokKelas?->id,
        'kelompok_kelas_nama' => $user->guru?->kelompokKelas?->nama_kelompok,
        'kelompok_kelas_guru_id' => $user->guru?->kelompokKelas?->guru_id,
    ], 200);
})->middleware('auth');

Route::get('/debug/siswa-check/{siswa_id}', function ($siswa_id) {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }

    $siswa = \App\Models\Siswa::with(['kelompokKelas'])->find($siswa_id);

    if (!$siswa) {
        return response()->json(['error' => 'Siswa not found'], 404);
    }

    return response()->json([
        'siswa_id' => $siswa->id,
        'nama_lengkap' => $siswa->nama_lengkap,
        'kelompok_kelas_id' => $siswa->kelompok_kelas_id,
        'kelompok_kelas_nama' => $siswa->kelompokKelas?->nama_kelompok,
    ], 200);
})->middleware('auth');

Route::get('/debug/policy-check/{siswa_id}', function ($siswa_id) {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }

    $user = auth()->user();
    $siswa = \App\Models\Siswa::find($siswa_id);

    if (!$siswa) {
        return response()->json(['error' => 'Siswa not found'], 404);
    }

    // Load relationships
    $user->load(['guru.kelompokKelas']);

    $userKelasId = optional($user->guru?->kelompokKelas)->id;
    $siswaKelasId = $siswa->kelompok_kelas_id;

    return response()->json([
        'user_id' => $user->id,
        'user_email' => $user->email,
        'user_role' => $user->role,
        'siswa_id' => $siswa->id,
        'siswa_nama' => $siswa->nama_lengkap,
        'user_kelas_id' => $userKelasId,
        'siswa_kelas_id' => $siswaKelasId,
        'can_create' => $userKelasId === $siswaKelasId,
        'policy_result' => $user->can('create', $siswa),
        'debug_message' => $userKelasId === $siswaKelasId ? 'AUTHORIZED' : 'UNAUTHORIZED (kelas tidak match)',
    ], 200);
})->middleware('auth');

