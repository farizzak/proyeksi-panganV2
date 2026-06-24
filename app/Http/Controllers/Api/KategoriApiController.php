<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MKategori;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KategoriApiController extends Controller
{
    public function index(): JsonResponse
    {
        $kategori = MKategori::orderBy('id', 'asc')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar kategori berhasil diambil.',
            'data' => $kategori->items(),
            'meta' => [
                'current_page' => $kategori->currentPage(),
                'last_page' => $kategori->lastPage(),
                'per_page' => $kategori->perPage(),
                'total' => $kategori->total(),
                'from' => $kategori->firstItem(),
                'to' => $kategori->lastItem(),
            ],
        ]);
    }

    public function count(): JsonResponse
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

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $check = MKategori::where('name', $validated['name'])->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori already exists!',
            ], 400);
        }

        $kategori = MKategori::create([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => $kategori,
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $check = MKategori::where('name', $validated['name'])
            ->where('id', '!=', $id)
            ->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori name already exists!',
            ], 400);
        }

        $kategori = MKategori::findOrFail($id);
        $kategori->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
            'data' => $kategori->fresh(),
        ]);
    }
}
