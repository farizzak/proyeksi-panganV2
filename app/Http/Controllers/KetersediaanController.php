<?php

namespace App\Http\Controllers;

use App\Models\MKomoditas;
use App\Models\TKetersediaan;
use App\Models\TKetersediaanDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KetersediaanController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $year  = $request->year;
            $month = $request->month;

            $query = TKetersediaan::query();

            if ($year) {
                $query->whereYear('tanggal', $year);
            }

            if ($month) {
                $query->whereMonth('tanggal', $month);
            }

            $datas = $query->orderByDesc('tanggal')->get();

            $datas->map(function ($item) {

                $date = \Carbon\Carbon::parse($item->tanggal);

                $weekOfMonth = $date->weekOfMonth;

                $item->tanggal_format = $date->format('Y-m-d') . " - Minggu Ke " . $weekOfMonth;

                return $item;
            });

            return datatables()->of($datas)
                ->addIndexColumn()
                ->addColumn('tanggal', function($row){
                    $date = \Carbon\Carbon::parse($row->tanggal);
                    $week = $date->weekOfMonth;

                    return $date->format('Y-m-d') . ' - <strong>Minggu Ke ' . $week . '</strong>';
                })
                ->rawColumns(['tanggal'])
                ->toJson();
        }

        return view('ketersediaan.index');
    }


    public function create()
    {
        $komoditas = MKomoditas::active()->get();

        return view('ketersediaan.create', compact('komoditas'));
    }

    /**
     * STORE — Simpan data baru
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'tanggal' => 'required|date',

            // array
            'komoditas_id' => 'required|array',
            'komoditas_id.*' => 'required|exists:m_komoditas,id',

            // numeric fields
            'harga_h_1.*' => 'required|numeric|min:0',
            'harga_hari_ini.*' => 'required|numeric|min:0',

            'stok_h_1.*' => 'required|numeric|min:0',
            'stok_distributor.*' => 'required|numeric|min:0',
            'stok_pasar.*' => 'required|numeric|min:0',
            'stok_pertanian.*' => 'required|numeric|min:0',
            'stok_bulog.*' => 'required|numeric|min:0',

            'stokrt.*' => 'required|numeric|min:0',
            'stoknonrt.*' => 'required|numeric|min:0',

            // asal pasokan
            'asal_pasokan' => 'nullable|array',
            'asal_pasokan.*' => 'nullable|string|max:1000',
        ]);

        // VALIDASI TAMBAHAN
        foreach ($request->komoditas_id as $i => $komoditasId) {
            $stokTotal = 
                floatval($request->stok_h_1[$i]) +
                floatval($request->stok_distributor[$i]) +
                floatval($request->stok_pasar[$i]) +
                floatval($request->stok_pertanian[$i]) +
                floatval($request->stok_bulog[$i]);

            $kebutuhanTotal = 
                floatval($request->stokrt[$i]) + 
                floatval($request->stoknonrt[$i]);

            if ($stokTotal <= 0) {
                return back()
                    ->withErrors(['komoditas_id' => "Jumlah stok total komoditas ID $komoditasId tidak boleh kosong"])
                    ->withInput();
            }

            if ($kebutuhanTotal <= 0) {
                return back()
                    ->withErrors(['komoditas_id' => "Total kebutuhan komoditas ID $komoditasId tidak boleh kosong"])
                    ->withInput();
            }
        }

        DB::beginTransaction();

        try {

            // SIMPAN HEADER
            $header = TKetersediaan::create([
                'tanggal' => $validated['tanggal'],
            ]);

            // DETAIL
            foreach ($request->komoditas_id as $i => $komoditasId) {

                $komoditas = MKomoditas::find($komoditasId);

                // Harga
                $hargaSebelumnya = floatval($request->harga_h_1[$i]);
                $hargaSekarang   = floatval($request->harga_hari_ini[$i]);

                $keteranganHarga = 
                    $hargaSekarang > $hargaSebelumnya ? 'Naik' :
                    ($hargaSekarang < $hargaSebelumnya ? 'Turun' : 'Tetap');

                // Perhitungan stok
                $stokAwal       = floatval($request->stok_h_1[$i] ?? 0);
                $stokDistributor = floatval($request->stok_distributor[$i] ?? 0);
                $stokPasar      = floatval($request->stok_pasar[$i] ?? 0);
                $stokPertanian  = floatval($request->stok_pertanian[$i] ?? 0);
                $stokBulog      = floatval($request->stok_bulog[$i] ?? 0);

                $stokTotal = $stokAwal + $stokDistributor + $stokPasar + $stokPertanian + $stokBulog;

                // kebutuhan
                $kebutuhanRT     = floatval($request->stokrt[$i] ?? 0);
                $kebutuhanNonRT  = floatval($request->stoknonrt[$i] ?? 0);
                $kebutuhanTotal  = $kebutuhanRT + $kebutuhanNonRT;

                // perhitungan neraca
                $tanggal = Carbon::parse($validated['tanggal']);
                $daysInMonth = $tanggal->daysInMonth;

                if ($stokAwal > 0) {
                    $neraca = $stokTotal - $kebutuhanTotal;
                    $perkiraan = $kebutuhanTotal / 7;
                    $bulan = floor($neraca / $perkiraan / $daysInMonth);
                    $hari  = floor(($neraca / $perkiraan) - ($bulan * $daysInMonth));
                    $kecukupanHarian = "{$bulan} Bulan {$hari} Hari";
                } else {
                    $neraca = 0;
                    $bulan = 0;
                    $hari = 0;
                    $kecukupanHarian = "0 Bulan 0 Hari";
                }

                // SIMPAN DETAIL
                TKetersediaanDetail::create([
                    'ketersediaan_id' => $header->id,
                    'komoditas_id' => $komoditasId,
                    'nama_komoditas' => $komoditas->name,
                    'satuan' => $komoditas->satuan,
                    'tanggal' => $validated['tanggal'],

                    'harga_sebelumnya' => $hargaSebelumnya,
                    'harga_hari_ini' => $hargaSekarang,
                    'keterangan_harga' => $keteranganHarga,

                    'stok_awal' => $stokAwal,
                    'stok_distributor' => $stokDistributor,
                    'stok_pasar' => $stokPasar,
                    'stok_produksi' => $stokPertanian,
                    'stok_bulog' => $stokBulog,

                    'jumlah_stok_total' => $stokTotal,

                    'kebutuhan_rt' => $kebutuhanRT,
                    'kebutuhan_nonrt' => $kebutuhanNonRT,
                    'total_kebutuhan' => $kebutuhanTotal,

                    'neraca' => $neraca,
                    'kecukupan_harian' => $kecukupanHarian,

                    'asal_pasokan' => $request->asal_pasokan[$i] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('ketersediaan.index', $header->id)
                ->with('success', 'Ketersediaan berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * EDIT
     */
    public function edit($id)
    {
        $ketersediaan = TKetersediaan::findOrFail($id);

        $detail = TKetersediaanDetail::where('ketersediaan_id', $id)->get()->keyBy('komoditas_id');

        $komoditas = MKomoditas::orderBy('name')->get();

        return view('ketersediaan.edit', compact('ketersediaan', 'komoditas', 'detail'));

    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        // validasi sama seperti store
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'komoditas_id' => 'required|array',
            'komoditas_id.*' => 'required|exists:m_komoditas,id',

            'harga_h_1.*' => 'required|numeric|min:0',
            'harga_hari_ini.*' => 'required|numeric|min:0',

            'stok_h_1.*' => 'required|numeric|min:0',
            'stok_distributor.*' => 'required|numeric|min:0',
            'stok_pasar.*' => 'required|numeric|min:0',
            'stok_pertanian.*' => 'required|numeric|min:0',
            'stok_bulog.*' => 'required|numeric|min:0',

            'stokrt.*' => 'required|numeric|min:0',
            'stoknonrt.*' => 'required|numeric|min:0',

            'asal_pasokan.*' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {

            // update header
            TKetersediaan::where('id', $id)->update([
                'tanggal' => $validated['tanggal'],
            ]);

            // per-komoditas
            foreach ($request->komoditas_id as $i => $komoditasId) {

                $komoditas = MKomoditas::find($komoditasId);

                // sama seperti store
                $hargaSebelumnya = floatval($request->harga_h_1[$i]);
                $hargaSekarang   = floatval($request->harga_hari_ini[$i]);

                $keteranganHarga = 
                    $hargaSekarang > $hargaSebelumnya ? 'Naik' :
                    ($hargaSekarang < $hargaSebelumnya ? 'Turun' : 'Tetap');

                $stokAwal = floatval($request->stok_h_1[$i]);
                $stokDistributor = floatval($request->stok_distributor[$i]);
                $stokPasar = floatval($request->stok_pasar[$i]);
                $stokPertanian = floatval($request->stok_pertanian[$i]);
                $stokBulog = floatval($request->stok_bulog[$i]);
                $stokTotal = $stokAwal + $stokDistributor + $stokPasar + $stokPertanian + $stokBulog;

                $kebutuhanRT = floatval($request->stokrt[$i]);
                $kebutuhanNonRT = floatval($request->stoknonrt[$i]);
                $kebutuhanTotal = $kebutuhanRT + $kebutuhanNonRT;

                $tanggal = Carbon::parse($validated['tanggal']);
                $daysInMonth = $tanggal->daysInMonth;

                if ($stokAwal > 0) {
                    $neraca = $stokTotal - $kebutuhanTotal;
                    $perkiraan = $kebutuhanTotal / 7;
                    $bulan = max(0, floor($neraca / $perkiraan / $daysInMonth));
                    $hari  = max(0, floor(($neraca / $perkiraan) - ($bulan * $daysInMonth)));
                    $kecukupan = "{$bulan} Bulan {$hari} Hari";
                } else {
                    $neraca = 0;
                    $kecukupan = "0 Bulan 0 Hari";
                }

                // update/detail
                TKetersediaanDetail::updateOrCreate(
                    [
                        'ketersediaan_id' => $id,
                        'komoditas_id'    => $komoditasId,
                    ],
                    [
                        'nama_komoditas' => $komoditas->name,
                        'satuan' => $komoditas->satuan,

                        'tanggal' => $validated['tanggal'],
                        'harga_sebelumnya' => $hargaSebelumnya,
                        'harga_hari_ini' => $hargaSekarang,
                        'keterangan_harga' => $keteranganHarga,

                        'stok_awal' => $stokAwal,
                        'stok_distributor' => $stokDistributor,
                        'stok_pasar' => $stokPasar,
                        'stok_produksi' => $stokPertanian,
                        'stok_bulog' => $stokBulog,

                        'jumlah_stok_total' => $stokTotal,
                        'kebutuhan_rt' => $kebutuhanRT,
                        'kebutuhan_nonrt' => $kebutuhanNonRT,
                        'total_kebutuhan' => $kebutuhanTotal,

                        'neraca' => $neraca,
                        'kecukupan_harian' => $kecukupan,

                        'asal_pasokan' => $request->asal_pasokan[$i] ?? null,
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('ketersediaan.index')
                ->with('success', 'Ketersediaan berhasil diperbarui');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Gagal update: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        TKetersediaan::where('id', $id)->delete();
        TKetersediaanDetail::where('ketersediaan_id', $id)->delete();

        return redirect()->route('ketersediaan.index')->with('success', 'Data berhasil dihapus');
    }
}
