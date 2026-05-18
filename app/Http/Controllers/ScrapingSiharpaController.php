<?php

namespace App\Http\Controllers;

use App\Models\MBahanPokok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingSiharpaController extends Controller
{
    private function normalizeDate(?string $date, string $fallback): string
    {
        if (empty($date)) {
            return $fallback;
        }

        try {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');
            }

            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
                return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return $fallback;
        }

        return $fallback;
    }

    private function parseHargaData(string $html): array
    {
        $crawler = new Crawler($html);

        if ($crawler->filter('#tbody_data_bahan_pokok > tr')->count() > 0) {
            return $crawler->filter('#tbody_data_bahan_pokok > tr')->each(function (Crawler $node) {
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
        }

        $appNode = $crawler->filter('#app');
        if ($appNode->count() === 0) {
            throw new \Exception("Struktur data sumber berubah dan tidak dapat diparse.");
        }

        $dataPageRaw = $appNode->attr('data-page');
        if (!$dataPageRaw) {
            throw new \Exception("Payload data sumber tidak ditemukan.");
        }

        $payload = json_decode(html_entity_decode($dataPageRaw, ENT_QUOTES | ENT_HTML5), true);
        $rows = $payload['props']['comparisonTable']['data'] ?? [];
        if (!is_array($rows)) {
            throw new \Exception("Data perbandingan harga tidak tersedia.");
        }

        return array_map(function ($row) {
            $harga1 = isset($row['harga_kemarin']) ? (float) $row['harga_kemarin'] : 0.0;
            $harga2 = isset($row['harga_hari_ini']) ? (float) $row['harga_hari_ini'] : 0.0;

            if ($harga1 == $harga2) {
                $keterangan = "Tetap";
            } elseif ($harga1 > $harga2) {
                $keterangan = "Turun";
            } else {
                $keterangan = "Naik";
            }

            return [
                'bahan_pokok' => $row['nama'] ?? '-',
                'satuan' => $row['satuan'] ?? '-',
                'harga_tanggal_1' => isset($row['harga_kemarin']) ? number_format((float) $row['harga_kemarin'], 2, '.', '') : '0',
                'harga_tanggal_2' => isset($row['harga_hari_ini']) ? number_format((float) $row['harga_hari_ini'], 2, '.', '') : '0',
                'persentase' => isset($row['persentase']) ? (string) $row['persentase'] : '0',
                'keterangan' => $keterangan,
            ];
        }, $rows);
    }

    public function index(Request $request)
    {
        $fromDate = $this->normalizeDate($request->input('from'), Carbon::yesterday()->format('Y-m-d'));
        $toDate = $this->normalizeDate($request->input('to'), Carbon::today()->format('Y-m-d'));

        try {
            $url = "https://siharpa.semarangkota.go.id/dashboard-harga?from={$fromDate}&to={$toDate}";
            // $response = Http::get($url);
            // $response = Http::timeout(60)->retry(3, 3000)->get($url);
            $response = Http::timeout(60)->get($url);

            if ($response->failed()) {
                throw new \Exception("Gagal mengambil data dari sumber eksternal.");
            }

            $data = $this->parseHargaData($response->body());

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
        $fromDate = $this->normalizeDate($request->input('from'), Carbon::yesterday()->format('Y-m-d'));
        $toDate = $this->normalizeDate($request->input('to'), Carbon::today()->format('Y-m-d'));

        try {
            $url = "https://siharpa.semarangkota.go.id/dashboard-harga?from={$fromDate}&to={$toDate}";
            $response = Http::timeout(60)->get($url);

            if ($response->failed()) {
                return response()->json(['error' => 'Gagal mengambil data dari sumber eksternal.'], 500);
            }

            $data = $this->parseHargaData($response->body());

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function scrapeData(Request $request)
    {
        $fromDate = $this->normalizeDate($request->input('from'), Carbon::yesterday()->format('Y-m-d'));
        $toDate = $this->normalizeDate($request->input('to'), Carbon::today()->format('Y-m-d'));


        $url = "https://siharpa.semarangkota.go.id/dashboard-harga?from={$fromDate}&to={$toDate}";
        // $response = Http::get($url);
        $response = Http::timeout(60)->get($url);
       
        $data = array_map(function ($item) {
            $item['persentase'] = floatval(str_replace(',', '', (string) $item['persentase']));
            return $item;
        }, $this->parseHargaData($response->body()));

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
