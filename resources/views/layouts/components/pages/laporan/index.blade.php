@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="text-[#0078C8]">Laporan Persediaan Harian Komponen</h1>
    </div>

    <div class="container mt-3">
        <div class="form-group">
            
            <div class="card -mx-2">
                <div class="card-body">
                    <label class="text-[#0078C8]">Buat Laporan Persediaan</label>
            <!-- Dropdown pilihan bengkel -->
            <select class="form-control" data-dropdown-css-class="select2-danger" style="background-color: #0078C8; width: 100%; color: white;" onchange="window.location.href=this.value;">
                <option class="bg-white" value="" selected disabled>Pilih Bagian</option>
                <option class="bg-white" value="{{ url('laporan/formPlastik?bagian=Plastik') }}">Plastik</option>
                <option class="bg-white" value="{{ url('laporan/formLogam?bagian=Logam') }}">Logam</option>
                {{-- <option value="{{ url('laporan/create/perakitan?bagian=Perakitan') }}">Perakitan</option> --}}
            </select></div></div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card -my-3">
    <div class="card-body">
        <h4 class="text-[#0078C8]">Data Laporan Persediaan Harian</h4>
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('laporan') }}" class="mb-3">
            <div class="row align-items-end">
                <!-- Search by User -->
                <div class="col-md-3">
                    <input 
                        type="text" 
                        name="user_name" 
                        class="form-control" 
                        placeholder="Search by user" 
                        value="{{ request('user_name') }}">
                </div>
                
                <!-- Search by Bagian -->
                <div class="col-md-3">
                    <input 
                        type="text" 
                        name="bagian" 
                        class="form-control" 
                        placeholder="Search by bagian" 
                        value="{{ request('bagian') }}">
                </div>
                
                <!-- Date Range -->
                <div class="col-md-4">
                    <div class="input-group">
                        <input 
                            type="date" 
                            name="start_date" 
                            class="form-control" 
                            value="{{ request('start_date') }}">
                        <input 
                            type="date" 
                            name="end_date" 
                            class="form-control" 
                            value="{{ request('end_date') }}">
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="col-md-2 text-right">
                    <button 
                        type="submit" 
                        class="btn" 
                        style="background-color: #0078C8; color: white;">
                        Search
                    </button>
                    <a href="{{ route('laporan') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>
        
        

        <table class="table table-striped table-bordered custom">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User</th>
                    <th>Bagian Laporan</th>
                    <th>Waktu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanHarians as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->user }}</td>
                        <td>{{ $laporan->bagian }}</td>
                        <td>{{ $laporan->created_at }}</td>
                        <td>
                            <a href="{{ route('laporan.view', $laporan->id) }}" class="btn" style="background-color: #0078C8; color: white;">View</a>
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
