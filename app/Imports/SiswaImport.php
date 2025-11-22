<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\KelompokKelas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    private $sekolahId;

    public function __construct()
    {
        $this->sekolahId = Auth::user()->sekolah_id;
    }

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.nama_lengkap' => 'required',
            '*.nama_kelompok_kelas' => 'required',
        ])->validate();

        foreach ($rows as $row) 
        {
            $kelompokKelas = KelompokKelas::where('sekolah_id', $this->sekolahId)
                                        ->where('nama_kelompok', $row['nama_kelompok_kelas'])
                                        ->first();

            // If class doesn't exist, skip this row.
            // A more robust solution might collect these errors and show them to the user.
            if (!$kelompokKelas) {
                continue;
            }

            Siswa::create([
                'sekolah_id' => $this->sekolahId,
                'kelompok_kelas_id' => $kelompokKelas->id,
                'nama_lengkap' => $row['nama_lengkap'],
                'nisn' => $row['nisn'] ?? null,
                'tempat_lahir' => $row['tempat_lahir'] ?? null,
                'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'alamat' => $row['alamat'] ?? null,
            ]);
        }
    }
}
