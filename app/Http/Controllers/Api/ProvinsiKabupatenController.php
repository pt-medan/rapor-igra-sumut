<?php

namespace App\Http\Controllers\Api;

use App\Data\ProvinsiKabupaten;
use Illuminate\Http\JsonResponse;

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
}
