@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Pengaduan</h1>
            </div>
            <div class="section-body">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Detail Pengaduan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Bukti Gambar</h5>
                                @if($pengaduan->image)
                                    <img src="{{ asset($pengaduan->image) }}" alt="Gambar Pengaduan" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">
                                @else
                                    <p>Tidak ada gambar</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5>Informasi Pengaduan</h5>
                                <table class="table table-striped table-hover table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $pengaduan->name }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge
                                                    @if($pengaduan->status == 'pending') bg-danger
                                                    @elseif($pengaduan->status == 'proses') bg-info
                                                    @elseif($pengaduan->status == 'selesai') bg-success
                                                    @endif text-white">
                                                    {{ ucfirst($pengaduan->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Laporan</th>
                                            <td>{{ $pengaduan->laporan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dibuat Oleh</th>
                                            <td>{{ $pengaduan->user }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dibuat pada</th>
                                            <td>{{ $pengaduan->created_at->format('d M Y H:i') }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('pengaduanuser.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('style')
<style>
    .table th, .table td {
        font-size: 1.1em; /* Membuat font lebih besar */
        color: #333; /* Warna teks yang lebih gelap */
    }

    .table {
        border: 2px solid #007bff; /* Mengatur warna dan ketebalan border tabel */
    }

    .table th {
        background-color: #f8f9fa; /* Warna latar belakang untuk header tabel */
        font-weight: bold; /* Membuat teks header lebih tebal */
    }

    .table-bordered {
        border: 2px solid #007bff; /* Mengatur border tabel */
    }

    .table-bordered th, .table-bordered td {
        border: 2px solid #007bff; /* Mengatur border sel tabel */
    }

    /* Menjamin responsivitas gambar */
    .img-fluid {
        max-width: 100%; /* Pastikan gambar tidak melebihi lebar kolom */
        height: auto; /* Pertahankan rasio aspek gambar */
    }
</style>
@endpush
