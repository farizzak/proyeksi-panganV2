<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MKomoditas;
use Illuminate\Http\JsonResponse;

class KomoditasApiController extends Controller
{
    public function index(): JsonResponse
    {
        $count = MKomoditas::count();

        return response()->json([
            'success' => true,
            'message' => 'Total komoditas berhasil diambil.',
            'data' => [
                'total_komoditas' => $count,
            ],
        ]);
    }
}
