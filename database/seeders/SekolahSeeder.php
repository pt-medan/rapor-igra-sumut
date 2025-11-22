<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sekolah::create([
            'nama_sekolah' => 'PAUD Tunas Bangsa',
            'npsn' => '12345678',
            'alamat' => 'Jl. Cendrawasih No. 123, Jakarta',
            'provinsi' => 'DKI Jakarta',
            'kabupaten' => 'Jakarta Pusat',
            'kepala_sekolah' => 'Ibu Budiarti',
            'status' => 'swasta',
        ]);
    }
}
