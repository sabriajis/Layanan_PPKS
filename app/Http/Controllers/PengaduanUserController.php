<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanUserController extends Controller
{
      // Menampilkan daftar pengaduan
      public function index(Request $request)
      {
          $userId = auth()->id(); // Mendapatkan ID pengguna yang sedang login
          // Mengambil pengaduan yang terkait dengan pengguna
          $pengaduans = Pengaduan::where('user_id', $userId)
              ->when($request->input('name'), function ($query, $name) {
                  $query->where('name', 'like', '%' . $name . '%')
                        ->orWhere('laporan', 'like', '%' . $name . '%');
              })
              ->paginate(10); // Menggunakan pagination

          return view('pages.pengaduanUser.index', compact('pengaduans'));
      }

    public function show($id)
    {
        // Memastikan pengguna hanya bisa mengakses pengaduannya sendiri
        $pengaduan = Pengaduan::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail(); // Menghasilkan 404 jika tidak ditemukan

        return view('pages.pengaduanUser.detail', compact('pengaduan'));
    }

    public function create()
    {
        return view('pages.pengaduanUser.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'user' => 'required|in:Mahasiswa,Dosen,anonim',
            'laporan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);


            // Ambil user ID
            $userId = auth()->id();
            if (!$userId) {
                return redirect()->back()->with('error', 'Anda harus login untuk membuat pengaduan.');
            }

        // Simpan gambar jika ada
        $imagePath = null; // Default jika tidak ada gambar
        if ($request->hasFile('image')) {
            // Mendapatkan file yang di-upload
            $image = $request->file('image');

            // Menentukan nama file dan path penyimpanan
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'assets/img/pengaduan/' . $imageName; // Path relatif

            // Memindahkan file ke public/assets/pengaduan
            $image->move(public_path('assets/img/pengaduan'), $imageName);
        }


        // Buat pengaduan baru
        Pengaduan::create([
            'name' => $request->name,
            'user' => $request->user,
            'laporan' => $request->laporan,
            'image' => $imagePath,
            'user_id' => $userId, // Mengisi user_id dengan ID pengguna yang sedang login
        ]);

        return redirect()->route('pengaduanuser.index')->with('success', 'Pengaduan created successfully');
    }
}
