<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KelompokKelas;
use App\Models\Sekolah;

class KelompokKelasController extends Controller
{
    public function getBySekolah(Sekolah $sekolah)
    {
        $kelasList = KelompokKelas::where('sekolah_id', $sekolah->id)
            ->whereNull('guru_id')
            ->get();

        return response()->json($kelasList);
    }
}
