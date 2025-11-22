<?php

namespace App\Http\Controllers\Api;

use App\Data\ProvinsiKabupaten;
use App\Models\Sekolah;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProvinsiKabupatenController
{
    /**
     * Get all provinsi
     */
    public function getProvinsi(): JsonResponse
    {
        return response()->json(ProvinsiKabupaten::getProvinsi());
    }

    /**
     * Get kabupaten by provinsi ID
     */
    public function getKabupaten(int $provinsiId): JsonResponse
    {
        $kabupaten = ProvinsiKabupaten::getKabupaten($provinsiId);

        if (empty($kabupaten)) {
            return response()->json(['error' => 'Provinsi tidak ditemukan'], 404);
        }

        return response()->json($kabupaten);
    }

    /**
     * Search sekolah by name
     */
    public function searchSekolah(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        $sekolahs = Sekolah::query();

        if (!empty($query)) {
            $sekolahs = $sekolahs->where('nama_sekolah', 'LIKE', '%' . $query . '%');
        }

        $results = $sekolahs->select('id', 'nama_sekolah')
            ->limit(10)
            ->get()
            ->map(function ($sekolah) {
                return [
                    'id' => $sekolah->id,
                    'nama_sekolah' => $sekolah->nama_sekolah,
                ];
            });

        return response()->json($results);
    }
}
