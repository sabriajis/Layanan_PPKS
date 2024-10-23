<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index (Request $request){
        $users = DB::table('users')
        ->when($request->input('name'), function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%')
                ->orWhere('email', 'like', '%' . $name . '%');
        })
        ->orderByRaw("CASE
        WHEN role = 'admin' THEN 1
        WHEN role = 'anggota' THEN 2
        WHEN role = 'user' THEN 3
        ELSE 4
        END")//membuat agar usernya berurutan
        ->paginate(10);
    return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }


    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,anggota,user',
        ]);



        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }


    public function show($id)
    {
        return view('pages.users.show');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required|in:admin,anggota,user',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();


        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }


    public function destroy($id)
    {

        $user = User::find($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
