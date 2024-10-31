<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // Menampilkan daftar pengaduan
    public function index(Request $request)
    {
        $pengaduans = Pengaduan::query()
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                      ->orWhere('laporan', 'like', '%' . $name . '%');
            })
            ->paginate(10);

        return view('pages.pengaduan.index', compact('pengaduans'));
    }

    // Menampilkan form untuk membuat pengaduan
    public function create()
    {
        return view('pages.pengaduan.create');
    }

    // Menyimpan pengaduan baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'user' => 'required|in:Mahasiswa,Dosen,anonim',
            'laporan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
        ]);

        return redirect()->route('pengaduan.create')->with('success', 'Pengaduan created successfully');
    }

    // Menampilkan detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('pages.pengaduan.detail', compact('pengaduan'));
    }

    // Menampilkan form edit pengaduan
    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('pages.pengaduan.edit', compact('pengaduan'));
    }

    // Mengupdate pengaduan di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'laporan' => 'required',
            'status' => 'required|in:pending,proses,selesai',
            'image' => 'nullable|image|max:2048', // Validasi gambar, jika ada
        ]);

        $pengaduan = Pengaduan::find($id);
        $pengaduan->name = $request->name;
        $pengaduan->laporan = $request->laporan;
        $pengaduan->user = $request->user;
        $pengaduan->status = $request->status;

        // Cek jika ada gambar yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($pengaduan->image) {
                $oldImagePath = public_path($pengaduan->image); // Path lama gambar
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Menghapus gambar lama
                }
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Menentukan nama unik untuk gambar
            $image->move(public_path('assets/img'), $imageName); // Pindahkan gambar ke folder yang diinginkan
            $pengaduan->image = 'assets/img/' . $imageName; // Simpan path gambar ke database
        }

        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan updated successfully');
    }



    // Menghapus pengaduan
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus gambar jika ada
        if ($pengaduan->image) {
            $oldImagePath = public_path($pengaduan->image); // Path lengkap
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Menghapus file
            }
        }

        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan deleted successfully');
    }
}
