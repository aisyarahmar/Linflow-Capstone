@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Sistem Bahan Baku</h1>
            @if(Auth::check())
                <h4>Halo {{ Auth::user()->nama }}</h4>
            @endif
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"><a href="#">Dashboard</a>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-5 col-sm-10">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Prediksi Produk</h5>
                            <p class="card-text">Jumlah meter air yang bisa dibuat:</p>
                            <h2>{{ $jumlahProduk }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-box fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>Daftar Stock Komponen Logam</h3>
                    <!-- <a href="?sort={{ $sortOrder == 'asc' ? 'desc' : 'asc' }}">Urutkan {{ $sortOrder == 'asc' ? 'Descending' : 'Ascending' }}</a> -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Komponen</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($komponenLogam as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>
                                        @if ($item->jumlah < 600)
                                            <i class="fas fa-circle" style="color: red;"></i>
                                        @else
                                            <i class="fas fa-circle" style="color: green;"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>Daftar Stock Komponen Plastik</h3>
                    <!-- <a href="?sort={{ $sortOrder == 'asc' ? 'desc' : 'asc' }}">Urutkan {{ $sortOrder == 'asc' ? 'Descending' : 'Ascending' }}</a> -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Komponen</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($komponenPlastik as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>
                                        @if ($item->jumlah < 600)
                                            <i class="fas fa-circle" style="color: red;"></i>
                                        @else
                                            <i class="fas fa-circle" style="color: green;"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection