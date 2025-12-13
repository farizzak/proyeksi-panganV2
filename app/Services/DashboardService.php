<?php

namespace App\Services;

use App\Models\MKomoditas;
use App\Models\MKategori;
use App\Models\User;
use App\Models\TKetersediaan;
use App\Models\TKetersediaanDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DashboardService
{
    /**
     * Return basic totals used in dashboard cards.
     */
    public function getTotals(): array
    {
        return [
            'userCount' => User::count(),
            'komoditasCount' => MKomoditas::active()->count(),
            'kategoriCount' => MKategori::count(),
        ];
    }

    /**
     * Count distinct komoditas reported in the current week.
     */
    public function getKomoditasThisWeek(): int
    {
        $start = Carbon::now()->startOfWeek()->toDateString();
        $end = Carbon::now()->endOfWeek()->toDateString();

        return TKetersediaanDetail::whereBetween('tanggal', [$start, $end])
            ->distinct('komoditas_id')
            ->count('komoditas_id');
    }

    /**
     * Compute status percentages for a date range (default: current week).
     * Uses TKetersediaanDetail.kecukupan_harian to group statuses.
     */
    public function getStatusPercentages($startDate = null, $endDate = null): array
    {
        $start = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfWeek();
        $end = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfWeek();

        $query = TKetersediaanDetail::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()]);

        $total = $query->count() ?: 0;

        $grouped = $query->select('kecukupan_harian', \DB::raw('count(*) as cnt'))
            ->groupBy('kecukupan_harian')
            ->get()
            ->keyBy('kecukupan_harian')
            ->map(fn($r) => $r->cnt)
            ->toArray();

        $aman = $grouped['Aman'] ?? ($grouped['aman'] ?? 0);
        $waspada = $grouped['Waspada'] ?? ($grouped['waspada'] ?? 0);
        $segera = $grouped['Segera'] ?? ($grouped['segera'] ?? 0);

        if ($total === 0) {
            return ['aman' => 0, 'waspada' => 0, 'segera' => 0];
        }

        return [
            'aman' => round($aman / $total * 100, 0),
            'waspada' => round($waspada / $total * 100, 0),
            'segera' => round($segera / $total * 100, 0),
        ];
    }

    /**
     * Top N komoditas by total_kebutuhan in the last period (default month).
     */
    public function getTopKebutuhan(int $limit = 3, $month = null, $year = null): Collection
    {
        $month = $month ?: Carbon::now()->month;
        $year = $year ?: Carbon::now()->year;

        $rows = TKetersediaanDetail::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->select('komoditas_id', 'nama_komoditas', \DB::raw('SUM(total_kebutuhan) as total_kebutuhan'))
            ->groupBy('komoditas_id', 'nama_komoditas')
            ->orderByDesc('total_kebutuhan')
            ->limit($limit)
            ->get();

        return $rows;
    }

    /**
     * Compute surplus and deficit totals (sum of neraca) in a period.
     */
    public function getSurplusDefisit($month = null, $year = null): array
    {
        $month = $month ?: Carbon::now()->month;
        $year = $year ?: Carbon::now()->year;

        $rows = TKetersediaanDetail::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->select(\DB::raw('SUM(CASE WHEN neraca > 0 THEN neraca ELSE 0 END) as surplus'), \DB::raw('SUM(CASE WHEN neraca < 0 THEN ABS(neraca) ELSE 0 END) as defisit'))
            ->first();

        return [
            'surplus' => $rows->surplus ?? 0,
            'defisit' => $rows->defisit ?? 0,
        ];
    }

    /**
     * Return highest and lowest harga_hari_ini in a period.
     */
    public function getHargaExtreme($month = null, $year = null): array
    {
        $month = $month ?: Carbon::now()->month;
        $year = $year ?: Carbon::now()->year;

        $max = TKetersediaanDetail::whereYear('tanggal', $year)->whereMonth('tanggal', $month)->orderByDesc('harga_hari_ini')->first();
        $min = TKetersediaanDetail::whereYear('tanggal', $year)->whereMonth('tanggal', $month)->orderBy('harga_hari_ini')->first();

        return [
            'max' => $max,
            'min' => $min,
        ];
    }
}
