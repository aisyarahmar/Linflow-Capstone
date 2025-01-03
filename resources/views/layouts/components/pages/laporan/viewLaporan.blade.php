@extends('layouts.main')

@section('header')
<h1 class="text-[#0078C8]">Detail Laporan Harian {{ $laporanHarian->bagian }}</h1>
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-body text-black">
        <div class="mb-3">
            <strong>Tanggal Laporan:</strong> {{ $laporanHarian->created_at }}<br>
            <strong>User:</strong> {{ $laporanHarian->user }}<br>
            <strong>Bagian:</strong> {{ $laporanHarian->bagian }}
        </div>
        <table class="table table-striped table-bordered custom">
            <thead>
                <tr>
                    <th >Nama Komponen</th>
                    <th>Stok Awal</th>
                    <th>Stok Masuk</th>
                    <th>Stok Keluar</th>
                    <th>Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailLaporans as $detail)
                    <tr>
                        <td>{{ $detail->nama_komponen }}</td>
                        <td>{{ $detail->stok_awal }}</td>
                        <td>{{ $detail->stok_masuk }}</td>
                        <td>{{ $detail->stok_keluar }}</td>
                        <td>{{ $detail->stok_akhir }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('laporan') }}" class="btn mt-3" style="background-color: #0078C8; color: white;">Kembali</a>
        <a href="{{ route('laporan.export', $laporanHarian->id) }}" class="btn btn-secondary mt-3">Export as CSV</a>
    </div>
</div>
@endsection