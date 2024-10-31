@extends('layouts.app')

@section('title', 'Pengaduan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengaduan</h1>
                <div class="section-header-button">
                    {{-- <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">Add New</a> --}}
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pengaduan</a></div>
                    <div class="breadcrumb-item">All Pengaduan</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">

                    </div>
                </div>
                <h2 class="section-title">Pengaduan</h2>
                <p class="section-lead">
                    You can manage all Pengaduan, such as editing, deleting, and more.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Pengaduan</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-left">
                                    <select class="form-control selectric">
                                        <option>Action For Selected</option>
                                        <option>Move to Draft</option>
                                        <option>Move to Pending</option>
                                        <option>Delete Permanently</option>
                                    </select>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('pengaduan.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Akun</th>
                                            <th>Tanggal Pengaduan</th>
                                            <th>Status Laporan</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($pengaduans as $pengaduan)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $pengaduan->name }}</td>
                                                <td>{{ $pengaduan->user }}</td>
                                                <td>{{ $pengaduan->created_at }}</td>
                                                <td>
                                                    <span class="badge
                                                        @if($pengaduan->status == 'pending') bg-danger
                                                        @elseif($pengaduan->status == 'proses') bg-info
                                                        @elseif($pengaduan->status == 'selesai') bg-success
                                                        @endif text-white">
                                                        {{ ucfirst($pengaduan->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                 <div class="d-flex justify-content-center">
                                                        <a href='{{ route('pengaduan.show', $pengaduan->id) }}' class="btn btn-sm btn-success btn-icon" style="margin-right: 10px;">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>

                                                        <a href='{{ route('pengaduan.edit', $pengaduan->id) }}' class="btn btn-sm btn-info btn-icon"">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete ">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $pengaduans->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
