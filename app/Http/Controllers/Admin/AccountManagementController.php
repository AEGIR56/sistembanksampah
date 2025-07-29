<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogHelper;
use Yajra\DataTables\DataTables;

class AccountManagementController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->paginate(10);
        return view('admin.accountManagement', compact('users'));
    }

    public function create()
    {
        return view('admin.accountManagementForm', ['user' => null]);
    }

    public function data()
    {
        $users = User::where('role', '!=', 'admin');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('actions', function ($user) {
                $editUrl = route('admin.accounts.edit', $user->id);
                $deleteUrl = route('admin.accounts.destroy', $user->id);

                return '
                <a href="' . $editUrl . '" class="btn btn-sm btn-warning text-white">Edit</a>
                <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus akun ini?\')">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,staff',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        LogHelper::record('Menambahkan akun baru', 'User ID: ' . $user->id);

        return redirect()->route('admin.accounts.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.accountManagementForm', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,staff',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only('username', 'email', 'role', 'phone_number');
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogHelper::record('Memperbarui akun', 'User ID: ' . $user->id);

        return redirect()->route('admin.accounts.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        LogHelper::record('Menghapus akun', 'User ID: ' . $user->id);

        return redirect()->route('admin.accounts.index')->with('success', 'User berhasil dihapus.');
    }
}
