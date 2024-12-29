@extends('layouts.main')

@section('header')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<title>Laporan Persediaan Harian Komponen Logam</title>
    <div class="col-sm-6">
        <h1>Laporan Persediaan Harian Komponen Logam</h1>
    </div>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('laporan.simpan') }}">
                @csrf
                <input type="hidden" name="bagian" value="{{ request('bagian') }}">
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                </div>
                @if ($komponenLogam)
                    @foreach ($komponenLogam as $komponen)
                        <div class="mb-3">
                            <label for="stok_awal_{{ $komponen->id }}" class="form-label">{{ $komponen->nama }}</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control" id="stok_awal_{{ $komponen->id }}" name="stok_awal[{{ $komponen->id }}]" value="{{ $komponen->jumlah }}" readonly>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" id="masuk_{{ $komponen->id }}" name="masuk[{{ $komponen->id }}]" placeholder="Masuk" min="0" required>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" id="keluar_{{ $komponen->id }}" name="keluar[{{ $komponen->id }}]" placeholder="Keluar" min="0" required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No data available for komponenLogam.</p>
                @endif
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection