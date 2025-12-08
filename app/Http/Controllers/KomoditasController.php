<?php

namespace App\Http\Controllers;

use App\Models\MKategori;
use App\Models\MKomoditas;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;

class KomoditasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = MKomoditas::with('kategori')->orderBy('id', 'asc');

            return datatables()->of($datas)
                ->addIndexColumn()
                ->addColumn('kategori', fn($row) => $row->kategori->name ?? '-')
                ->addColumn('status_toggle', fn($row) => $row->status)
                ->toJson();
        }

        $aktif = MKomoditas::where('status', 1)->count();
        $nonAktif = MKomoditas::where('status', 0)->count();
        $total = MKomoditas::count();

        return view('komoditas.index', compact('aktif', 'nonAktif', 'total'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $results['kategories'] = MKategori::orderBy('id', 'asc')->get();
        return view('komoditas.create', $results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'kategori_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'tipe_acuan' => 'required|string|in:HAP,HET',
            'batas_aman' => 'nullable|numeric',
            'batas_waspada' => 'nullable|numeric',
            'batas_intervensi' => 'nullable|numeric',
            'url_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fileUrl = null;

        if ($request->hasFile('url_gambar')) {
            $file = $request->file('url_gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('attachment/komoditas'), $filename);

            // Simpan filename sebagai URL + folder
            $fileUrl = 'attachment/komoditas/' . $filename;
        }

        MKomoditas::create([
            'kategori_id' => $request->kategori_id,
            'name' => $request->name,
            'satuan' => $request->satuan,
            'tipe_acuan' => $request->tipe_acuan,
            'batas_aman' => $request->batas_aman,
            'batas_waspada' => $request->batas_waspada,
            'batas_intervensi' => $request->batas_intervensi,
            'url_gambar' => $fileUrl,
        ]);

        return redirect()->route('komoditas.index')->with('success', 'Komoditas berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $results['komoditas'] = MKomoditas::findOrFail($id);
        $results['kategories'] = MKategori::orderBy('id', 'asc')->get();
        return view('komoditas.edit', $results);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $komoditas = MKomoditas::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'tipe_acuan' => 'required|string|in:HAP,HET',
            'batas_aman' => 'nullable|numeric',
            'batas_waspada' => 'nullable|numeric',
            'batas_intervensi' => 'nullable|numeric',
            'url_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fileUrl = $komoditas->url_gambar;

        if ($request->hasFile('url_gambar')) {

            // Hapus file lama
            if ($fileUrl && file_exists(public_path($fileUrl))) {
                unlink(public_path($fileUrl));
            }

            $file = $request->file('url_gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('attachment/komoditas'), $filename);

            $fileUrl = 'attachment/komoditas/' . $filename;
        }

        $komoditas->update([
            'kategori_id' => $request->kategori_id,
            'name' => $request->name,
            'satuan' => $request->satuan,
            'tipe_acuan' => $request->tipe_acuan,
            'batas_aman' => $request->batas_aman,
            'batas_waspada' => $request->batas_waspada,
            'batas_intervensi' => $request->batas_intervensi,
            'url_gambar' => $fileUrl,
        ]);

        return redirect()->route('komoditas.index')->with('success', 'Komoditas berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request, $id)
    {
        $komoditas = MKomoditas::findOrFail($id);

        $komoditas->status = $request->status == 1 ? 1 : 0;
        $komoditas->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated!'
        ]);
    }

    public function destroy($id)
    {
        $komoditas = MKomoditas::findOrFail($id);
        $komoditas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komoditas deleted!'
        ]);
    }

    
}
