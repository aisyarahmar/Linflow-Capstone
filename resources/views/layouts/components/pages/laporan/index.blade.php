@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Laporan Persediaan Harian Komponen</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan</li>
        </ol>
    </div>

    <div class="container mt-3">
        <div class="form-group">
            <label>Buat Laporan Persediaan</label>
            <!-- Dropdown pilihan bengkel -->
            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="window.location.href=this.value;">
                <option value="" selected disabled>Pilih Bagian</option>
                <option value="{{ url('laporan/formPlastik?bagian=Plastik') }}">Plastik</option>
                <option value="{{ url('laporan/formLogam?bagian=Logam') }}">Logam</option>
                <option value="{{ url('laporan/create/perakitan?bagian=Perakitan') }}">Perakitan</option>
            </select>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-body">
        <h4>Data Laporan Persediaan Harian</h4>
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('laporan') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="user_name" class="form-control" placeholder="Search by user" value="{{ request('user_name') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="bagian" class="form-control" placeholder="Search by bagian" value="{{ request('bagian') }}">
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('laporan') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Bagian Laporan</th>
                    <th>Waktu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanHarians as $laporan)
                    <tr>
                        <td>{{ $laporan->id }}</td>
                        <td>{{ $laporan->user }}</td>
                        <td>{{ $laporan->bagian }}</td>
                        <td>{{ $laporan->created_at }}</td>
                        <td>
                            <a href="{{ route('laporan.view', $laporan->id) }}" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-kA09DDfh0DzPb22/sFTZHHk7l0NRT9V1rsZy5otzH9bsGv9AomXy/USJ3Se4nV4Xm" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Initialize select2 if you are using it
        $('.select2').select2();
    });
</script>
@endsection
