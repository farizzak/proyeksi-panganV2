<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MKomoditas;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class PantauanHargaApiController extends Controller
{
    public function index(): JsonResponse
    {
        $komoditas = MKomoditas::with('bahanPokokTerbaru')
            ->active()
            ->get();

        $tanggalTerakhir = $komoditas
            ->pluck('bahanPokokTerbaru')
            ->filter()
            ->pluck('created_at')
            ->max();

        $data = $komoditas->map(function ($item) {
            $bahan = $item->bahanPokokTerbaru;
            $persentase = (float) ($bahan->persentase ?? 0);
            $keterangan = $bahan->keterangan ?? 'Belum ada data';

            return [
                'id' => $item->id,
                'name' => $bahan->bahan_pokok ?? $item->name ?? '-',
                'persentase' => $persentase,
                'persentase_label' => $this->formatPersentase($persentase),
                'keterangan' => $keterangan,
                'status' => $this->normalizeStatus($keterangan),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'message' => 'Data pantauan harga berhasil diambil.',
            'data' => [
                'tanggal_terakhir' => $tanggalTerakhir
                    ? Carbon::parse($tanggalTerakhir)->translatedFormat('d F Y')
                    : '-',
                'total_komoditas' => $data->count(),
                'items' => $data,
            ],
        ]);
    }

    private function formatPersentase(float $persentase): string
    {
        $formatted = rtrim(rtrim(number_format($persentase, 2, '.', ''), '0'), '.');

        return $formatted === '' ? '0%' : $formatted . '%';
    }

    private function normalizeStatus(?string $keterangan): string
    {
        switch ($keterangan) {
            case 'Naik':
                return 'up';
            case 'Turun':
                return 'down';
            case 'Tetap':
                return 'flat';
            default:
                return 'unknown';
        }
    }
}
