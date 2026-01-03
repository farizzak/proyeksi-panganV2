<?php

namespace App\Exports;

use App\Models\TKetersediaanDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KetersediaanPanganExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        // Mendapatkan data dari model dengan penambahan nomor urut manual
        $data = TKetersediaanDetail::all([
            'nama_komoditas', 
            'harga_sebelumnya', 
            'harga_hari_ini', 
            'keterangan_harga', 
            'satuan', 
            'kebutuhan_bulanan', 
            'kebutuhan_harian', 
            'stok_h_1', 
            'stok_distributor', 
            'stok_pasar', 
            'stok_pertanian', 
            'stok_bulog', 
            'jumlah_stok_saat_ini', 
            'jumlah_stok_total', 
            'neraca', 
            'kecukupan_harian', 
            'asal_pasokan'
        ]);

        // Tambahkan nomor urut pada setiap data
        $numberedData = $data->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Komoditas' => $item->nama_komoditas,
                'Harga (H-1)' => $item->harga_sebelumnya,
                'Harga Hari Ini' => $item->harga_hari_ini,
                'Keterangan Harga' => $item->keterangan_harga,
                'Satuan' => $item->satuan,
                'Kebutuhan Bulanan' => $item->kebutuhan_bulanan,
                'Kebutuhan Harian' => $item->kebutuhan_harian,
                'Stok (H-1)' => $item->stok_h_1,
                'Stok Distributor' => $item->stok_distributor,
                'Stok Pasar' => $item->stok_pasar,
                'Stok Pertanian' => $item->stok_pertanian,
                'Stok Bulog' => $item->stok_bulog,
                'Jumlah Stok Saat Ini' => $item->jumlah_stok_saat_ini,
                'Jumlah Stok Total' => $item->jumlah_stok_total,
                'Neraca' => $item->neraca,
                'Kecukupan Harian' => $item->kecukupan_harian,
                'Asal Pasokan' => $item->asal_pasokan,
            ];
        });

        return collect($numberedData);
    }

    public function headings(): array
    {
        // Header untuk Excel
        return [
            'No', 
            'Komoditas', 
            'Harga (H-1)', 
            'Harga Hari Ini', 
            'Keterangan Harga', 
            'Satuan', 
            'Kebutuhan Bulanan', 
            'Kebutuhan Harian', 
            'Stok (H-1)', 
            'Stok Distributor', 
            'Stok Pasar', 
            'Stok Pertanian', 
            'Stok Bulog', 
            'Jumlah Stok Saat Ini', 
            'Jumlah Stok Total', 
            'Neraca', 
            'Kecukupan Harian', 
            'Asal Pasokan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFF2F2']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ]
        ]);

        // Atur kolom untuk teks wrap
        $sheet->getStyle('B')->getAlignment()->setWrapText(true); // Kolom Komoditas
        $sheet->getStyle('Q')->getAlignment()->setWrapText(true); // Kolom Kecukupan Harian

        // Mengatur lebar kolom otomatis
        foreach (range('A', 'R') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        return $sheet;
    }
}
