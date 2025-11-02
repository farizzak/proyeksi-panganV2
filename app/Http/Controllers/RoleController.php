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
        $data = $request->except(['_token', '_method']);

        $check = MRole::where('name', @$request->name)->first();

        if ($check) {
            return redirect('roles')->with('error', 'Role already exist!');
        }

        MRole::create($data);

        return redirect('roles')->with('success', 'Role saved!');
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
        //
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
        $data = $request->except(['_token', '_method']);

        $check = MRole::where('name', @$request->name)->where('id', '!=', $id)->first();

        if ($check) {
            return redirect('roles')->with('error', 'Role name already exist!');
        }

        MRole::find($id)->update($data);

        return redirect('roles')->with('success', 'Role updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MRole::find($id)->delete();

        return redirect('roles')->with('success', 'Role deleted!');
    }
}
