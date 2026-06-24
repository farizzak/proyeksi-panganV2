<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MKomoditas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KomoditasApiController extends Controller
{
    public function index(): JsonResponse
    {
        $komoditas = MKomoditas::with('kategori')
            ->orderBy('id', 'asc')
            ->paginate(10);

        $items = $komoditas->getCollection()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kategori_id' => $item->kategori_id,
                    'kategori_name' => $item->kategori->name ?? null,
                    'name' => $item->name,
                    'satuan' => $item->satuan,
                    'status' => $item->status,
                    'tipe_acuan' => $item->tipe_acuan,
                    'batas_aman' => $item->batas_aman,
                    'batas_waspada' => $item->batas_waspada,
                    'batas_intervensi' => $item->batas_intervensi,
                    'url_gambar' => $item->url_gambar,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Daftar komoditas berhasil diambil.',
            'data' => $items->values(),
            'meta' => [
                'current_page' => $komoditas->currentPage(),
                'last_page' => $komoditas->lastPage(),
                'per_page' => $komoditas->perPage(),
                'total' => $komoditas->total(),
                'from' => $komoditas->firstItem(),
                'to' => $komoditas->lastItem(),
            ],
        ]);
    }

    public function count(): JsonResponse
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

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kategori_id' => 'required|integer|exists:m_kategoris,id',
            'name' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'tipe_acuan' => 'required|string|in:HAP,HET',
            'batas_aman' => 'nullable|numeric',
            'batas_waspada' => 'nullable|numeric',
            'batas_intervensi' => 'nullable|numeric',
            'url_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fileUrl = null;

        if ($request->hasFile('url_gambar')) {
            $file = $request->file('url_gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('attachment/komoditas'), $filename);
            $fileUrl = 'attachment/komoditas/' . $filename;
        }

        $komoditas = MKomoditas::create([
            'kategori_id' => $validated['kategori_id'],
            'name' => $validated['name'],
            'satuan' => $validated['satuan'] ?? null,
            'tipe_acuan' => $validated['tipe_acuan'],
            'batas_aman' => $validated['batas_aman'] ?? null,
            'batas_waspada' => $validated['batas_waspada'] ?? null,
            'batas_intervensi' => $validated['batas_intervensi'] ?? null,
            'url_gambar' => $fileUrl,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komoditas berhasil ditambahkan.',
            'data' => $komoditas->load('kategori'),
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $komoditas = MKomoditas::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|integer|exists:m_kategoris,id',
            'name' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'tipe_acuan' => 'required|string|in:HAP,HET',
            'batas_aman' => 'nullable|numeric',
            'batas_waspada' => 'nullable|numeric',
            'batas_intervensi' => 'nullable|numeric',
            'url_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fileUrl = $komoditas->url_gambar;

        if ($request->hasFile('url_gambar')) {
            if ($fileUrl && File::exists(public_path($fileUrl))) {
                File::delete(public_path($fileUrl));
            }

            $file = $request->file('url_gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('attachment/komoditas'), $filename);
            $fileUrl = 'attachment/komoditas/' . $filename;
        }

        $komoditas->update([
            'kategori_id' => $validated['kategori_id'],
            'name' => $validated['name'],
            'satuan' => $validated['satuan'] ?? null,
            'tipe_acuan' => $validated['tipe_acuan'],
            'batas_aman' => $validated['batas_aman'] ?? null,
            'batas_waspada' => $validated['batas_waspada'] ?? null,
            'batas_intervensi' => $validated['batas_intervensi'] ?? null,
            'url_gambar' => $fileUrl,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komoditas berhasil diperbarui.',
            'data' => $komoditas->fresh()->load('kategori'),
        ]);
    }
}
