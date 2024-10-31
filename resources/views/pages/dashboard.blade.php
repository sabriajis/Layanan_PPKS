@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <style>
        canvas {
            max-width: 100%;
            height: auto; /* Membuat tinggi otomatis berdasarkan lebar */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard - PPKS</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total User</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUser }} <!-- Menampilkan jumlah total user -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pengaduan</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPengaduan }} <!-- Menampilkan jumlah total pengaduan -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 col-12 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics - Pengaduan Harian</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="182"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Distribution of Reports</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart" height="182"></canvas> <!-- Diagram Lingkaran -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>

    <script>
        // Mendapatkan data dari blade
        const dates = @json($dates);
        const counts = @json($counts);
        const mahasiswa = @json($dataMahasiswa); // Data mahasiswa
        const dosen = @json($dataDosen); // Data dosen
        const anonim = @json($dataAnonim); // Data anonim

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line', // Tipe grafik yang ingin digunakan
            data: {
                labels: dates, // Tanggal
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: counts, // Data jumlah pengaduan
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Diagram lingkaran
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Mahasiswa', 'Dosen', 'Anonim'], // Label untuk diagram
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: [mahasiswa, dosen, anonim], // Data untuk diagram
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribusi Pengaduan'
                    }
                }
            }
        });
    </script>
@endpush
