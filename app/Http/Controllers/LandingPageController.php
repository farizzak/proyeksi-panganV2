<?php

namespace App\Http\Controllers;

use App\Models\MKomoditas;
use App\Models\TKetersediaanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TDistribution;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{

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
    // Landing Dashboard
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

    // Landing Komoditas
    public function komoditasPage(Request $request){

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

        return view('landingpages.komoditas', compact('selectedData','namaBulan','tahun'));
    }

    public function getLandingKomoditas(Request $request){

        $bulan = $request->get('bulan', date('n')); 
        $tahun = $request->get('tahun', date('Y')); 
    
        $allKomoditas = MKomoditas::where('status', 1)->get();
    
        $response = [];
    
        foreach ($allKomoditas as $komoditas) {
            $selectedDataPerKomoditas = TKetersediaanDetail::selectRaw('MONTH(tanggal) as bulan, SUM(neraca) as neraca')
                ->whereYear('tanggal', $tahun)
                ->where('komoditas_id', $komoditas->id) 
                ->groupByRaw('MONTH(tanggal)')
                ->orderByRaw('MONTH(tanggal)')
                ->get();

            
            $latestMonth = TKetersediaanDetail::whereYear('tanggal', $tahun)
            ->where('komoditas_id', $komoditas->id)
            ->orderBy('tanggal', 'desc')
            ->first();
    
            $stokBulan = [];
            $totalNeraca = [];
    
            foreach ($selectedDataPerKomoditas as $data) {
                $stokBulan[] = Carbon::create()->month($data->bulan)->locale('id')->translatedFormat('F'); 
                $totalNeraca[] = $data->neraca;
            }
    

            $response[] = [
                'komoditas' => $komoditas->name,
                'labels' => $stokBulan,
                'data' => $totalNeraca,
                'tahun' => $tahun,
                'summary' => [
                    'jumlah_stok_total' => $latestMonth->jumlah_stok_total ?? 0,
                    'total_kebutuhan' => $latestMonth->total_kebutuhan ?? 0,
                    'neraca' => $latestMonth->neraca ?? 0,
                    'bulan' => $latestMonth ? Carbon::parse($latestMonth->tanggal)->translatedFormat('F') : 'Tidak Ada Data',
                ]
            ];
        }
    
        return response()->json($response);

    }

    // Landing PantauanHarga
    public function pantauanHargaPage(Request $request){

        $komoditas = MKomoditas::with('bahanPokokTerbaru')->active()->get();
        $tanggal = $komoditas
            ->pluck('bahanPokokTerbaru')
            ->filter()
            ->pluck('created_at')
            ->max();

        $tanggalFormatted = $tanggal ? Carbon::parse($tanggal)->translatedFormat('d F Y') : '-';

        return view('landingpages.pantauan-harga', compact('komoditas','tanggalFormatted'));
    }

    public function petaPage(Request $request)
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
        $data = TDistribution::where('year','=', $tahun)
            ->where('bulan','=',$bulan)
            ->first();

        $komoditasDropdown = DB::table('t_distributions')
            ->select('kecamatan')->distinct()
            ->where('bulan', 11)
            ->where('year', 2024)
            ->get();

        return view('landingpages.peta', compact('komoditasDropdown','namaBulan','data'));

    }

    public function getLandingPeta(Request $request)
    {
       
        $tahun = $request->get('tahun', date('Y')); 
        $bulan = $request->get('bulan', date('n'));
    
        $data = DB::table('t_distributions')
            ->select('kecamatan', 'komoditas', DB::raw('SUM(stock) as total_stok')) 
            ->where('year', $tahun)
            ->where('bulan', $bulan)
            ->groupBy('kecamatan', 'komoditas') 
            ->orderBy('kecamatan')
            ->get();
        
        $result = [];
        foreach ($data as $row) {
            $kecamatanKey = strtolower(str_replace(' ', '', $row->kecamatan));
            if (!isset($result[$kecamatanKey])) {
                $result[$kecamatanKey] = [
                    'nama' => $row->kecamatan,
                    'komoditas' => [],
                ];
            }
    
            $result[$kecamatanKey]['komoditas'][] = [
                'nama' => $row->komoditas,
                'stok' => "{$row->total_stok} kg",
            ];
        }
    
        return response()->json($result);
    }

}
