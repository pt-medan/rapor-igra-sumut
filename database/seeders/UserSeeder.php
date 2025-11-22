<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first school to associate users with
        $sekolah = Sekolah::first();

        // 1. Admin Provinsi
        User::create([
            'name' => 'Milda',
            'email' => 'milda@igrasumut.com',
            'password' => Hash::make('password'),
            'role' => 'admin_provinsi',
            'status' => 'active',
            'validated_at' => now(),
        ]);

        if ($sekolah) {
            // 2. Guru Aktif
            $guruAktif = User::create([
                'name' => 'Ibu Guru Aktif',
                'email' => 'guru.aktif@example.com',
                'password' => Hash::make('password'),
                'sekolah_id' => $sekolah->id,
                'role' => 'guru',
                'status' => 'active',
                'validated_at' => now(),
            ]);

            // Create a Guru profile for the active guru
            $guruAktif->guru()->create([
                'nama_guru' => $guruAktif->name,
                'sekolah_id' => $sekolah->id,
            ]);

            // 3. Guru Pending
            User::create([
                'name' => 'Bapak Guru Pending',
                'email' => 'guru.pending@example.com',
                'password' => Hash::make('password'),
                'sekolah_id' => $sekolah->id,
                'role' => 'guru',
                'status' => 'pending',
            ]);
        }
    }
}
