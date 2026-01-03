<?php

namespace App\Http\Controllers;

use App\Models\MBahanPokok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingSiharpaController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('from') ?? Carbon::yesterday()->format('d-m-Y');
        $toDate = $request->input('to') ?? Carbon::today()->format('d-m-Y');

        try {
            $url = "https://siharpa.semarangkota.go.id/dashboard-harga-pasar?bapok=&pasar=&from={$fromDate}&to={$toDate}&sgbtn=Apply&param=1";
            // $response = Http::get($url);
            // $response = Http::timeout(60)->retry(3, 3000)->get($url);
            $response = Http::timeout(60)->get($url);

            if ($response->failed()) {
                throw new \Exception("Gagal mengambil data dari sumber eksternal.");
            }

            $html = $response->body();
            $crawler = new Crawler($html);

            $data = $crawler->filter('#tbody_data_bahan_pokok > tr')->each(function (Crawler $node) {
                $harga_tanggal_1 = floatval(str_replace(',', '', $node->filter('td:nth-child(3) .list_group-id_bapok')->text()));
                $harga_tanggal_2 = floatval(str_replace(',', '', $node->filter('td:nth-child(4) .list_group-id_bapok')->text()));

                if ($harga_tanggal_1 == $harga_tanggal_2) {
                    $keterangan = "Tetap";
                } elseif ($harga_tanggal_1 > $harga_tanggal_2) {
                    $keterangan = "Turun";
                } else {
                    $keterangan = "Naik";
                }


                return [
                    'bahan_pokok' => $node->filter('td:nth-child(1) .list_group-id_bapok')->text(),
                    'satuan' => $node->filter('td:nth-child(2) .list_group-id_bapok')->text(),
                    'harga_tanggal_1' => $node->filter('td:nth-child(3) .list_group-id_bapok')->text(),
                    'harga_tanggal_2' => $node->filter('td:nth-child(4) .list_group-id_bapok')->text(),
                    'persentase' => $node->filter('td:nth-child(5) .list_group-id_bapok')->text(),
                    'keterangan' => $keterangan
                ];
            });

            return view('bahanpokok.index', compact('data', 'fromDate', 'toDate'));
        } catch (\Exception $e) {
            return view('bahanpokok.index', [
                'data' => [],
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'error' => $e->getMessage()
            ]);
        }

    }

    public function scrapeAjax(Request $request)
    {
        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        try {
            $url = "https://siharpa.semarangkota.go.id/dashboard-harga-pasar?bapok=&pasar=&from={$fromDate}&to={$toDate}&sgbtn=Apply&param=1";
            $response = Http::timeout(60)->get($url);

            if ($response->failed()) {
                return response()->json([
                    'data' => [],
                    'error' => 'Sumber data sedang pemeliharaan atau tidak dapat diakses.'
                ]);
            }

            $html = $response->body();
            $crawler = new Crawler($html);

            $tbody = $crawler->filter('#tbody_data_bahan_pokok');
            if ($tbody->count() === 0) {
                return response()->json([
                    'data' => [],
                    'error' => 'Struktur sumber data berubah atau sedang pemeliharaan.'
                ]);
            }

            $data = $tbody->filter('> tr')->each(function (Crawler $node) {
                $harga_tanggal_1 = floatval(str_replace(',', '', $node->filter('td:nth-child(3) .list_group-id_bapok')->text()));
                $harga_tanggal_2 = floatval(str_replace(',', '', $node->filter('td:nth-child(4) .list_group-id_bapok')->text()));

                if ($harga_tanggal_1 == $harga_tanggal_2) {
                    $keterangan = "Tetap";
                } elseif ($harga_tanggal_1 > $harga_tanggal_2) {
                    $keterangan = "Turun";
                } else {
                    $keterangan = "Naik";
                }


                return [
                    'bahan_pokok' => $node->filter('td:nth-child(1) .list_group-id_bapok')->text(),
                    'satuan' => $node->filter('td:nth-child(2) .list_group-id_bapok')->text(),
                    'harga_tanggal_1' => $node->filter('td:nth-child(3) .list_group-id_bapok')->text(),
                    'harga_tanggal_2' => $node->filter('td:nth-child(4) .list_group-id_bapok')->text(),
                    'persentase' => $node->filter('td:nth-child(5) .list_group-id_bapok')->text(),
                    'keterangan' => $keterangan
                ];
            });

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Gagal mengambil data. Silakan coba lagi nanti.'
            ]);
        }
    }



    public function scrapeData(Request $request)
    {
        $fromDate = $request->input('from') ?? Carbon::yesterday()->format('d-m-Y');
        $toDate = $request->input('to') ?? Carbon::today()->format('d-m-Y');


        $url = "https://siharpa.semarangkota.go.id/dashboard-harga-pasar?bapok=&pasar=&from={$fromDate}&to={$toDate}&sgbtn=Apply&param=1";
        // $response = Http::get($url);
        $response = Http::timeout(60)->get($url);
       
        $html = $response->body();
        $crawler = new Crawler($html);
        $data = $crawler->filter('#tbody_data_bahan_pokok > tr')->each(function (Crawler $node) {
            $harga_tanggal_1 = floatval(str_replace(',', '', $node->filter('td:nth-child(3) .list_group-id_bapok')->text()));
            $harga_tanggal_2 = floatval(str_replace(',', '', $node->filter('td:nth-child(4) .list_group-id_bapok')->text()));
        
            // Tentukan nilai keterangan
            if ($harga_tanggal_1 == $harga_tanggal_2) {
                $keterangan = "Tetap";
            } elseif ($harga_tanggal_1 > $harga_tanggal_2) {
                $keterangan = "Turun";
            } else {
                $keterangan = "Naik";
            }
            // Konversi persentase menjadi decimal
            $persentase = floatval(str_replace(',', '', $node->filter('td:nth-child(5) .list_group-id_bapok')->text()));

            return [
                'bahan_pokok' => $node->filter('td:nth-child(1) .list_group-id_bapok')->text(),
                'satuan' => $node->filter('td:nth-child(2) .list_group-id_bapok')->text(),
                'harga_tanggal_1' => $node->filter('td:nth-child(3) .list_group-id_bapok')->text(),
                'harga_tanggal_2' => $node->filter('td:nth-child(4) .list_group-id_bapok')->text(),
                'persentase' => $persentase,
                'keterangan' => $keterangan,
            ];
        });

        foreach ($data as $item) {
            // MBahanPokok::create($item);
            $harga_tanggal_1 = floatval(str_replace(',', '', $item['harga_tanggal_1']));
            $harga_tanggal_2 = floatval(str_replace(',', '', $item['harga_tanggal_2']));
                    
            $existingData = MBahanPokok::where('bahan_pokok', $item['bahan_pokok'])
                                ->whereDate('created_at', Carbon::today())
                                ->first();

            if ($existingData) {
                // Jika data sudah ada, lakukan update
                $existingData->update([
                    'satuan' => $item['satuan'],
                    'harga_tanggal_1' => $harga_tanggal_1,
                    'harga_tanggal_2' => $harga_tanggal_2,
                    'persentase' => $item['persentase'],
                    'keterangan' => $item['keterangan'],
                ]);
            } else {
                // Jika data belum ada, lakukan create
                MBahanPokok::create([
                    'bahan_pokok' => $item['bahan_pokok'],
                    'satuan' => $item['satuan'],
                    'harga_tanggal_1' => $harga_tanggal_1,
                    'harga_tanggal_2' => $harga_tanggal_2,
                    'persentase' => $item['persentase'],
                    'keterangan' => $item['keterangan'],
                ]);
            }
        }

        return redirect()->route('bahanpokok.index')->with('success', 'Data berhasil disimpan.');
    }

    public function storeDataFromTable(Request $request)
    {
        $items = $request->data;

        foreach ($items as $item) {
            $harga_tanggal_1 = floatval(str_replace(',', '', $item['harga_tanggal_1']));
            $harga_tanggal_2 = floatval(str_replace(',', '', $item['harga_tanggal_2']));

            $existing = MBahanPokok::where('bahan_pokok', $item['bahan_pokok'])
                ->whereDate('created_at', now()->toDateString())
                ->first();

            if ($existing) {
                $existing->update([
                    'satuan' => $item['satuan'],
                    'harga_tanggal_1' => $harga_tanggal_1,
                    'harga_tanggal_2' => $harga_tanggal_2,
                    'persentase' => $item['persentase'],
                    'keterangan' => $item['keterangan'],
                ]);
            } else {
                MBahanPokok::create([
                    'bahan_pokok' => $item['bahan_pokok'],
                    'satuan' => $item['satuan'],
                    'harga_tanggal_1' => $harga_tanggal_1,
                    'harga_tanggal_2' => $harga_tanggal_2,
                    'persentase' => $item['persentase'],
                    'keterangan' => $item['keterangan'],
                ]);
            }
        }

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }



}
