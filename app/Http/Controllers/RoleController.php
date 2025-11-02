<?php

namespace App\Http\Controllers;

use App\Models\MRole;
use Illuminate\Http\Request;

class RoleController extends Controller
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
            $datas = MRole::orderBy('id', 'asc')->get();
            return datatables()->of($datas)->addIndexColumn()->toJson();
        }

        return view('roles.index', $results);
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
        $check = MRole::where('name', $request->name)->first();

        if ($check) {
            return response()->json(['message' => 'Role already exists!'], 400);
        }

        MRole::create(['name' => $request->name]);

        return response()->json(['message' => 'Role saved successfully!']);
    }

    public function update(Request $request, $id)
    {
        $check = MRole::where('name', $request->name)
                    ->where('id', '!=', $id)
                    ->first();

        if ($check) {
            return response()->json(['message' => 'Role name already exists!'], 400);
        }

        MRole::findOrFail($id)->update(['name' => $request->name]);

        return response()->json(['message' => 'Role updated successfully!']);
    }

    public function destroy($id)
    {
        MRole::findOrFail($id)->delete();

        return response()->json(['message' => 'Role deleted successfully!']);
    }
}
