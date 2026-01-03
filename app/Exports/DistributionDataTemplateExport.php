<?php

namespace App\Exports;

use App\Models\MKecamatan;
use App\Models\MKomoditas;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DistributionDataTemplateExport implements FromView, WithTitle
{
    protected $month;

    public function __construct($month)
    {
        $this->month = Carbon::parse($month);
    }

    public function view(): View
    {
        // Retrieve all kecamatans and commodities
        $kecamatans = MKecamatan::all();
        $commodities = MKomoditas::all();

        // Generate data rows
        $rows = [];
        foreach ($kecamatans as $kecamatan) {
            foreach ($commodities as $commodity) {
                $rows[] = [
                    'Kecamatan' => $kecamatan->name,
                    'Komoditas' => $commodity->name,
                    'Bulan' => $this->month->format('F Y'),
                    'Distributor' => '',  
                    'Pedagang' => '',      
                    'Pasok' => 0,
                    'Satuan Pasok' => $commodity->satuan,
                    'Penjualan' => 0,
                    'Satuan Penjualan' => $commodity->satuan,
                    'Stock' => 0,
                    'Satuan Stock' => $commodity->satuan,
                    'Harga' => 0,
                    'Asal' => '',
                    'Alamat' => '',
                    'Tujuan Pemasaran' => ''
                ];
            }
        }

        return view('exports.distribution_data_template', [
            'rows' => $rows,
            'month' => $this->month
        ]);
    }

    public function title(): string
    {
        return 'Distribution Data Template';
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER, // Kolom Pasok
            'H' => NumberFormat::FORMAT_NUMBER, // Kolom Penjualan
            'J' => NumberFormat::FORMAT_NUMBER, // Kolom Stock
            'L' => NumberFormat::FORMAT_NUMBER_00, // Kolom Harga (dengan 2 desimal)
        ];
    }
}
