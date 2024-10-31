<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total user
        $totalUser = User::where('role', 'user')->count(); // Misalkan 'role' adalah kolom yang menunjukkan peran pengguna

        // Ambil total pengaduan yang telah dilaporkan
        $totalPengaduan = Pengaduan::count(); // Menghitung total pengaduan

        // Ambil data pengaduan harian
        $dailyReports = Pengaduan::selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Format data untuk Chart.js
        $dates = $dailyReports->pluck('date');
        $counts = $dailyReports->pluck('count');

        // Ambil jumlah pengaduan berdasarkan kategori
        $dataMahasiswa = Pengaduan::where('user', 'mahasiswa')->count(); // Menghitung pengaduan dari mahasiswa
        $dataDosen = Pengaduan::where('user', 'dosen')->count(); // Menghitung pengaduan dari dosen
        $dataAnonim = Pengaduan::where('user', 'anonim')->count(); // Menghitung pengaduan dari anonim

        // Kirim data ke view
        return view('pages.dashboard', compact('totalUser', 'totalPengaduan', 'dates', 'counts', 'dataMahasiswa', 'dataDosen', 'dataAnonim'));
    }
}
