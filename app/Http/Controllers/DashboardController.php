<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        $totals = $this->service->getTotals();
        $status = $this->service->getStatusPercentages();
        $top = $this->service->getTopKebutuhan(3, $month, $year);
        $sd = $this->service->getSurplusDefisit($month, $year);
        $harga = $this->service->getHargaExtreme($month, $year);
        $komoditasThisWeek = $this->service->getKomoditasThisWeek();

        return view('admin.dashboard', array_merge($totals, [
            'status' => $status,
            'topKebutuhan' => $top,
            'surplusDefisit' => $sd,
            'hargaExtreme' => $harga,
            'komoditasThisWeek' => $komoditasThisWeek,
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]));
    }
}
