<?php

namespace App\Http\Controllers;

use App\Models\MKomoditas;
use App\Models\TKetersediaanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DistributionData;

class LandingPageController extends Controller
{
    public function dashboardPage(Request $request){

        $bulan = $request->get('bulan', date('n')); 
        $tahun = $request->get('tahun', date('Y')); 
        $komoditasID = $request->get('komoditas_id') ?? 1;
        $namakomoditas = MKomoditas::find($komoditasID);
        $namaBulan = $this->getNamaBulan($bulan);
    
        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth()->format('Y-m-d');

        
        $selectedData = TKetersediaanDetail::where('tanggal', '>=', $startOfMonth)
            ->where('tanggal', '<=', $endOfMonth)
            ->get(); 

        if (!$selectedData) {
            $selectedData = collect([]);
        }
    
        $selectedDataPerkomoditas = TKetersediaanDetail::selectRaw('MONTH(tanggal) as bulan, SUM(neraca) as neraca')
            ->whereYear('tanggal', $tahun)
            ->where('komoditas_id','=',$komoditasID)
            ->groupByRaw('MONTH(tanggal)')
            ->orderByRaw('MONTH(tanggal)')
            ->get();

        $stokBulan = [];
        $totalNeraca = [];

        foreach ($selectedDataPerkomoditas as $data) {
            $stokBulan[] = Carbon::create()->month($data->bulan)->format('F'); 
            $totalNeraca[] = $data->neraca;
        }

        $Mkomoditas = MKomoditas::where('status', 1)->get();

        return view('landingpages.dashboard', compact('selectedData','namaBulan','tahun','selectedDataPerkomoditas','stokBulan', 'totalNeraca','namakomoditas','Mkomoditas'));
        
    }

    public function getKomoditas(Request $request){

        $bulan = $request->get('bulan', date('n')); 
        $tahun = $request->get('tahun', date('Y')); 
        $namaBulan = $this->getNamaBulan($bulan);
       
        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth()->format('Y-m-d');

        $selectedData = TKetersediaanDetail::where('tanggal', '>=', $startOfMonth)
              ->where('tanggal', '<=', $endOfMonth)
              ->get(); 
  
        if (!$selectedData) {
            $selectedData = collect([]);
        }

        return view('komoditas', compact('selectedData','namaBulan','tahun'));
    }

    public function getDataStokByMonthAndYear(Request $request)
    {
        $bulan = $request->input('bulan'); 
        $tahun = $request->input('tahun'); 

        $bulan = $bulan ?: now()->month;
        $tahun = $tahun ?: now()->year;

        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $data = TKetersediaanDetail::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->selectRaw('MONTH(tanggal) as month, YEAR(tanggal) as year, SUM(jumlah_stok_total) as total_stock')
            ->groupBy('month', 'year')
            ->orderBy('tanggal', 'asc')
            ->get();

        return response()->json($data);
    }

    public function getPeta(Request $request)
    {
        $bulan = $request->input('bulan'); 
        $tahun = $request->input('tahun'); 

        $bulan = $bulan ?: now()->month;
        $tahun = $tahun ?: now()->year;
        $komoditasID = $request->get('komoditas_id') ?? 1;
        $namakomoditas = MKomoditas::find($komoditasID);
        $namaBulan = $this->getNamaBulan($bulan);

        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth();
        $data = DistributionData::where('year','=', $tahun)
            ->where('bulan','=',$bulan)
            ->first();

        $komoditasDropdown = MKomoditas::where('status', 1)->get();
        return view('peta', compact('komoditasDropdown','namaBulan','data'));

    }

    function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $namaBulan[$bulan] ?? 'Tidak Diketahui';
    }
}
