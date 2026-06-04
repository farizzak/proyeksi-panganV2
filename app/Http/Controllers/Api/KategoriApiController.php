<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MKategori;
use Illuminate\Http\JsonResponse;

class KategoriApiController extends Controller
{
    public function index(): JsonResponse
    {
        $count = MKategori::count();

        return response()->json([
            'success' => true,
            'message' => 'Total kategori berhasil diambil.',
            'data' => [
                'total_kategori' => $count,
            ],
        ]);
    }
}
