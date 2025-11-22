<?php

namespace App\Http\Controllers;

use App\Models\MKategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = [];

        if($request->ajax()){
            $datas = MKategori::orderBy('id', 'asc')->get();
            return datatables()->of($datas)->addIndexColumn()->toJson();
        }

        return view('kategori.index', $results);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = MKategori::where('name', $request->name)->first();

        if ($check) {
            return response()->json(['message' => 'Kategori already exists!'], 400);
        }

        MKategori::create(['name' => $request->name]);

        return response()->json(['message' => 'Kategori saved successfully!']);
    }

    public function update(Request $request, $id)
    {
        $check = MKategori::where('name', $request->name)
                    ->where('id', '!=', $id)
                    ->first();

        if ($check) {
            return response()->json(['message' => 'Kategori name already exists!'], 400);
        }

        MKategori::findOrFail($id)->update(['name' => $request->name]);

        return response()->json(['message' => 'Kategori updated successfully!']);
    }

    public function destroy($id)
    {
        MKategori::findOrFail($id)->delete();

        return response()->json(['message' => 'Kategori deleted successfully!']);
    }

    public function show($id)
{
    return MKategori::find($id);
}

}
