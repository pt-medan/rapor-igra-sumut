<?php

namespace App\Policies;

use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenilaianPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Siswa $siswa): bool
    {
        // Admin bisa melihat semua, guru hanya dari kelas siswa yang bisa melihat daftar penilaian
        if ($user->role === 'admin' || $user->role === 'manager') {
            return true;
        }
        // Cast to int to handle string/int type mismatch
        $userKelasId = (int) ($user->guru?->kelompokKelas?->id ?? 0);
        $siswaKelasId = (int) ($siswa->kelompok_kelas_id ?? 0);
        return $user->role === 'guru' && $userKelasId === $siswaKelasId && $userKelasId > 0;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Penilaian $penilaian = null): bool
    {
        // Admin bisa melihat semua
        if ($user->role === 'admin' || $user->role === 'manager') {
            return true;
        }

        if ($penilaian && $user->role === 'guru') {
            // FIXED: Access kelas_id through relationship, cast to int to handle type mismatch
            $userKelasId = (int) (optional($user->guru?->kelompokKelas)->id ?? 0);
            $siswaKelasId = (int) (optional($penilaian->siswa)->kelompok_kelas_id ?? 0);

            // Debug info
            if (!$userKelasId || !$siswaKelasId) {
                \Log::warning('PenilaianPolicy::view - Missing kelas IDs', [
                    'user_id' => $user->id,
                    'user_kelas_id' => $userKelasId,
                    'penilaian_id' => $penilaian->id,
                    'siswa_kelas_id' => $siswaKelasId,
                ]);
            }

            return $userKelasId === $siswaKelasId && $userKelasId > 0;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Siswa $siswa): bool
    {
        // Admin bisa membuat untuk siapa saja
        if ($user->role === 'admin' || $user->role === 'manager') {
            return true;
        }

        // Guru hanya bisa membuat untuk siswa di kelasnya
        if ($user->role === 'guru') {
            // FIXED: Access kelas_id through relationship, cast to int to handle type mismatch
            $userKelasId = (int) (optional($user->guru?->kelompokKelas)->id ?? 0);
            $siswaKelasId = (int) ($siswa->kelompok_kelas_id ?? 0);

            // Debug info (dapat dihapus setelah testing)
            if (!$userKelasId || !$siswaKelasId) {
                \Log::warning('PenilaianPolicy::create - Missing kelas IDs', [
                    'user_id' => $user->id,
                    'user_kelas_id' => $userKelasId,
                    'siswa_id' => $siswa->id,
                    'siswa_kelas_id' => $siswaKelasId,
                ]);
            }

            return $userKelasId === $siswaKelasId && $userKelasId > 0;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Penilaian $penilaian = null): bool
    {
        // Admin bisa update semua
        if ($user->role === 'admin' || $user->role === 'manager') {
            return true;
        }

        if ($penilaian && $user->role === 'guru') {
            // FIXED: Access kelas_id through relationship, cast to int to handle type mismatch
            $userKelasId = (int) (optional($user->guru?->kelompokKelas)->id ?? 0);
            $siswaKelasId = (int) (optional($penilaian->siswa)->kelompok_kelas_id ?? 0);

            // Debug info
            if (!$userKelasId || !$siswaKelasId) {
                \Log::warning('PenilaianPolicy::update - Missing kelas IDs', [
                    'user_id' => $user->id,
                    'user_kelas_id' => $userKelasId,
                    'penilaian_id' => $penilaian->id,
                    'siswa_kelas_id' => $siswaKelasId,
                ]);
            }

            return $userKelasId === $siswaKelasId && $userKelasId > 0;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Penilaian $penilaian = null): bool
    {
        // Admin bisa delete semua
        if ($user->role === 'admin' || $user->role === 'manager') {
            return true;
        }

        if ($penilaian && $user->role === 'guru') {
            // FIXED: Access kelas_id through relationship, cast to int to handle type mismatch
            $userKelasId = (int) (optional($user->guru?->kelompokKelas)->id ?? 0);
            $siswaKelasId = (int) (optional($penilaian->siswa)->kelompok_kelas_id ?? 0);

            // Debug info
            if (!$userKelasId || !$siswaKelasId) {
                \Log::warning('PenilaianPolicy::delete - Missing kelas IDs', [
                    'user_id' => $user->id,
                    'user_kelas_id' => $userKelasId,
                    'penilaian_id' => $penilaian->id,
                    'siswa_kelas_id' => $siswaKelasId,
                ]);
            }

            return $userKelasId === $siswaKelasId && $userKelasId > 0;
        }

        return false;
    }
}
