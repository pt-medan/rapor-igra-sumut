<?php

namespace Database\Seeders;

use App\Models\KelompokKelas;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;

class KelompokKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolah = Sekolah::where('npsn', '12345678')->first(); // Get the school created by SekolahSeeder

        if ($sekolah) {
            // Get the active guru user
            $guruAktif = User::where('email', 'guru.aktif@example.com')->first();

            if ($guruAktif && $guruAktif->guru) {
                KelompokKelas::create([
                    'sekolah_id' => $sekolah->id,
                    'guru_id' => $guruAktif->guru->id,
                    'nama_kelompok' => 'Kelas A',
                    'tahun_ajaran' => '2025/2026',
                ]);
            }
        }
    }
}
