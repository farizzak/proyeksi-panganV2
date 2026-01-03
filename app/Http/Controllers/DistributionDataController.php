<?php

namespace App\Http\Controllers;

use App\Models\TDistribution;
use App\Models\TKecamatan;
use App\Models\MKomoditas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class DistributionDataController extends Controller
{

    public function index(Request $request)
    {
        $query = TDistribution::query();
        $kecamatan = TDistribution::query()
            ->select('kecamatan')
            ->whereNotNull('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan', 'kecamatan');

        $months = TDistribution::query()
            ->select('bulan')
            ->whereNotNull('bulan')
            ->distinct()
            ->orderBy('bulan')
            ->pluck('bulan');

        $currentYear = now()->year;

        $years = collect(range($currentYear - 5, $currentYear))->sortDesc();


        // dd($years);    

        // Filter by kecamatan (langsung dari kolom t_distributions.kecamatan)
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Filter by month and year (langsung dari kolom t_distributions.bulan & t_distributions.year)
        if ($request->filled('month')) {
            $query->where('bulan', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $data = $query->paginate(10);
        return view('distributiondata.index', compact('data', 'request', 'kecamatan', 'months', 'years'));
    }

    public function indextemplate(Request $request){
        $month = $request->input('month') ?? now()->format('Y-m-d');
        return view('exports.template', compact('month'));
    }


    public function exportTemplate($month)
    {
        // Parse month
        $year = now()->year;
        // $parsedMonth = Carbon::createFromDate($year, $month, 1);

        // Ambil data kecamatan dan komoditas
        $kecamatans = TKecamatan::all();
        $commodities = MKomoditas::where('status','=',1)->get();

        // Buat array data untuk diekspor
        $rows = [];
        foreach ($kecamatans as $kecamatan) {
            foreach ($commodities as $commodity) {
                $rows[] = [
                    'year' => $year,
                    'bulan' => $month,
                    'kecamatan' => $kecamatan->name,
                    'distributor' => '', 
                    'pedagang' => '',     
                    'komoditas' => $commodity->name,
                    'pasokan' => 0,
                    'satuan_pasokan' => $commodity->satuan,
                    'penjualan' => 0,
                    'satuan_penjualan' => $commodity->satuan,
                    'stock' => 0,
                    'satuan_stock' => $commodity->satuan,
                    'harga' => 0,
                    'asal' => '',
                    'alamat' => '',
                    'tujuan_pemasaran' => '',
                    'no_tlp' => ''
                ];
            }
        }

        // Gunakan Excel::download untuk mengekspor data
        return Excel::download(new DistributionDataExport($rows), 'DistributionDataTemplate.xlsx');
    }

    public function uploadTemplate(Request $request)
    {
        // Validasi file yang diunggah harus berupa Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Ambil file dari request
        $file = $request->file('file');

        // Baca file Excel menggunakan Maatwebsite Excel
        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file);

        // Asumsikan data pada sheet pertama
        $sheetData = $data[0];
        $year = now()->year;
        $month = now()->month;
        $delDistibustionData = TDistribution::where('year','=',$year)
            ->where('bulan','=',$month)
            ->delete();
        // Looping untuk setiap baris dan simpan ke dalam database
        foreach ($sheetData as $index => $row) {
            // Lewati header atau baris pertama jika ada header
            if ($index === 0) continue;
            // Cari kecamatan berdasarkan nama
            $kecamatan = TKecamatan::where('name', $row[2] ?? null)->first();
            // Simpan data ke tabel TDistribution
            
            TDistribution::create([
                'year' => $row[0] ?? null,
                'bulan' => $row[1] ?? null,
                'kecamatan_id' => $kecamatan ? $kecamatan->id : null,
                'kecamatan' => $row[2] ?? null,
                'distributor' => $row[3] ?? null,
                'pedagang' => $row[4] ?? null,
                'komoditas' => $row[5] ?? null,
                'pasokan' => $row[6] ?? 0,
                'satuan_pasokan' => $row[7] ?? null,
                'penjualan' => $row[8] ?? 0,
                'satuan_penjualan' => $row[9] ?? null,
                'stock' => $row[10] ?? 0,
                'satuan_stock' => $row[11] ?? null,
                'harga' => $row[12] ?? 0,
                'asal' => $row[13] ?? null,
                'alamat' => $row[14] ?? null,
                'tujuan_pemasaran' => $row[15] ?? null,
                'no_tlp' => $row[16] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diupload.');
    }
}



class DistributionDataExport implements FromCollection, WithHeadings, WithColumnWidths
{
    protected $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function collection()
    {
        return collect($this->rows);
    }

    public function headings(): array
    {
        return [
           'Tahun',
           'Bulan',
           'Kecamatan',
           'Distributor',
           'Pedagang',
           'Komoditas',
           'Pasokan',
           'Satuan Pasokan',
           'Penjualan',
           'Satuan Penjualan',
           'Stock',
           'Satuan Stock',
           'Harga',
           'Asal',
           'Alamat',
           'Tujuan Pemasaran',
           'No Tlp',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER,      // Kolom pasokan
            'I' => NumberFormat::FORMAT_NUMBER,      // Kolom penjualan
            'K' => NumberFormat::FORMAT_NUMBER,      // Kolom stock
            'M' => NumberFormat::FORMAT_NUMBER_00,   // Kolom harga
        ];
    }

    public function columnWidths(): array
    {
        return [
            'C' => 15, 
            'D' => 25,  
            'E' => 30,   
            'F' => 24, 
            'G' => 15, 
            'H' => 14, 
            'I' => 15, 
            'J' => 14, 
            'K' => 15, 
            'L' => 14, 
            'M' => 15,        
        ];
    }

    // public static function afterSheet(AfterSheet $event)
    // {
    //     $sheet = $event->sheet->getDelegate();
        
    //     // Mengatur warna untuk kolom tertentu
    //     $sheet->getStyle('G:G')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setARGB('FFCCE5FF'); // Warna biru muda
    //     $sheet->getStyle('I:I')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setARGB('FFFFE5CC'); // Warna oranye muda
    //     $sheet->getStyle('K:K')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setARGB('FFE5FFCC'); // Warna hijau muda
    //     $sheet->getStyle('M:M')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setARGB('FFFFCCE5'); // Warna merah muda
    //     // $sheet->getStyle('H:H')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //     //     ->getStartColor()->setARGB('FFCCFFE5'); // Warna hijau kebiruan
    // }

    public function registerEvents(): array
    {
        // return [
        //     AfterSheet::class => [self::class, 'afterSheet'],
        // ];
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Terapkan warna pada kolom G, I, K, M
                $sheet->getStyle('G:G')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFCCE5FF'); // Biru muda
                $sheet->getStyle('I:I')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFE5CC'); // Oranye muda
                $sheet->getStyle('K:K')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE5FFCC'); // Hijau muda
                $sheet->getStyle('M:M')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFCCE5'); // Merah muda
            },
        ];
    }

    // public function defaultStyles(Style $defaultStyle)
    // {
    //     // Configure the default styles
    //     return $defaultStyle->getFill()->setFillType(Fill::FILL_SOLID);
    
    //     // Or return the styles array
    //     return [
    //         'fill' => [
    //             'fillType'   => Fill::FILL_SOLID,
    //             'startColor' => ['argb' => Color::COLOR_RED],
    //         ],
    //     ];
    // }

}
