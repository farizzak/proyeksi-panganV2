<?php

namespace App\Http\Controllers;

use App\Models\MKomoditas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapKetersediaan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $currentMonth = date('m');
        $currentYear = date('Y');

        $month = $request->filled('month') ? $request->month : $currentMonth;
        $year = $request->filled('year') ? $request->year : $currentYear;

        // Jalankan query SQL
        $results = DB::table('t_ketersediaan_details as ak')
            ->join('m_komoditas as k', function ($join) {
                $join->on('k.id', '=', 'ak.komoditas_id')
                    ->where('k.status', 1);
            })
            ->select(
                'ak.komoditas_id',
                'k.url_gambar',
                'k.name as nama_komoditas',
                'k.satuan',
                DB::raw('SUM(ak.jumlah_stok_total) as jumlah_stok_total'),
                DB::raw('MONTH(ak.tanggal) as bulan'),
                DB::raw('YEAR(ak.tanggal) as tahun')
            )
            ->whereMonth('ak.tanggal', $month)
            ->whereYear('ak.tanggal', $year)
            ->groupBy(
                'ak.komoditas_id',
                'k.url_gambar',
                'k.name',
                'k.satuan',
                DB::raw('YEAR(ak.tanggal)'),
                DB::raw('MONTH(ak.tanggal)')
            )
            ->orderBy('ak.komoditas_id')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

            
        // dd($results);

        // Return ke view
       
        return view('rekapketersediaan.index', [
            'm_komoditas' => $results,
            'month' => $month,
            'year' => $year,
            'request' => $request
        ]);
       
      
    }

    public function detail(Request $request, $id){
        // Default tahun
        $currentYear = date('Y');
        $year = $request->filled('year') ? $request->year : $currentYear;

        // Query data berdasarkan m_komoditas dan tahun
        $details = DB::table('t_ketersediaan_details as ak')
            ->select(
                DB::raw('MONTH(ak.tanggal) as bulan'),
                DB::raw('SUM(ak.stok_awal) as stok_awal'),
                DB::raw('SUM(ak.stok_produksi) as stok_produksi'),
                DB::raw('SUM(ak.stok_distributor) as stok_distributor'),
                DB::raw('SUM(ak.stok_bulog) as stok_bulog'),
                DB::raw('SUM(ak.jumlah_stok_total) as jumlah_stok_total'),
                DB::raw('SUM(ak.kebutuhan_rt) as kebutuhan_rt'),
                DB::raw('SUM(ak.kebutuhan_nonrt) as kebutuhan_nonrt'),
                DB::raw('SUM(ak.total_kebutuhan) as total_kebutuhan'),
                DB::raw('SUM(ak.neraca) as neraca'),
                DB::raw('SUM(ak.angka_kecukupan) as angka_kecukupan'),
            )
            ->where('ak.komoditas_id', $id)
            ->whereYear('ak.tanggal', $year)
            ->groupBy(DB::raw('MONTH(ak.tanggal)'))
            ->orderBy('bulan')
            ->get();


        $m_komoditas = DB::table('m_komoditas')->select('id', 'name', 'satuan')->where('id', $id)->first();

      
        return view('rekapketersediaan.detail', [
            'details' => $details,
            'm_komoditas' => $m_komoditas,
            'year' => $year,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function laporanperkomoditas(Request $request)
    {
        // Default bulan dan tahun (bulan & tahun ini)
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Ambil filter bulan dan tahun dari request, atau gunakan default
        $month = $request->filled('month') ? $request->month : $currentMonth;
        $year = $request->filled('year') ? $request->year : $currentYear;

        // Jalankan query SQL
        $results = DB::select("
            SELECT 
                ak.komoditas_id,
                k.name AS nama_komoditas,
                k.satuan,
                SUM(ak.jumlah_stok_total) AS jumlah_stok_total,
                GROUP_CONCAT(DISTINCT ak.asal_pasokan SEPARATOR ', ') AS asal_pasokan,
                MONTH(ak.tanggal) AS bulan,
                YEAR(ak.tanggal) AS tahun
            FROM 
                t_ketersediaan_details AS ak
            JOIN 
                m_komoditas k ON k.id = ak.komoditas_id AND k.status = 1
            WHERE 
                MONTH(ak.tanggal) = ? AND YEAR(ak.tanggal) = ?
            GROUP BY 
                ak.komoditas_id, k.name, k.satuan, MONTH(ak.tanggal), YEAR(ak.tanggal)
            ORDER BY 
                ak.komoditas_id
        ", [$month, $year]);

        return view('admin.rekapketersediaan.ketersediaanbulanan', [
            'm_komoditas' => $results,
            'month' => $month,
            'year' => $year
        ]);
    }
}
