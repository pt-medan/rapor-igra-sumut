<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'nama_lengkap',
            'nisn',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'nama_kelompok_kelas',
        ];
    }
}
