<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {
        // Mengambil pengguna dengan relasi roles dan filter berdasarkan nama atau email
        $users = User::with('roles')
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                      ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        // Mengambil semua role untuk ditampilkan di form create
        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed', // Menambahkan konfirmasi password
            'role' => 'required|exists:roles,name',
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Menambahkan role ke pengguna
        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        // Mengambil pengguna berdasarkan ID
        $user = User::with('roles')->findOrFail($id);
        return view('pages.users.show', compact('user'));
    }

    public function edit($id)
    {
        // Mengambil pengguna dan semua role untuk form edit
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('pages.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed', // Menambahkan konfirmasi password
            'role' => 'required|exists:roles,name',
        ]);

        // Mengambil pengguna berdasarkan ID
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya memperbarui password jika ada input
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sinkronisasi role baru
        $user->syncRoles([$request->role]);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        // Mengambil pengguna berdasarkan ID dan menghapusnya
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
