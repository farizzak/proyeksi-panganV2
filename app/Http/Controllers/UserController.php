<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // INDEX
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = User::with('role')->orderBy('id', 'asc')->get();

            return datatables()->of($datas)
                ->addIndexColumn()
                ->addColumn('role', function($row) {
                    return $row->role->name ?? '-';
                })
                ->toJson();
        }

        return view('users.index');
    }

    // CREATE
    public function create()
    {
        $roles = MRole::orderBy('name')->get();
        return view('users.create', compact('roles'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'role_id'  => 'required|integer|exists:m_roles,id',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
        dd($request->all());

    }

    // EDIT
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = MRole::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role_id'  => 'nullable|integer',
        ]);

        $data = $request->only(['username', 'name', 'email', 'role_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    // DELETE
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    // RESTORE
    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('users.index')->with('success', 'User berhasil dikembalikan.');
    }
}
