@extends('layouts.main')

@section('header')

@endsection

@section('content')
<div class="container-fluid">
    <!-- Row 1: Title & Filter | Prediction Card -->
    <div class="container-fluid">
        <!-- Row 1: Main Heading -->
        <div class="row -mt-3">
            <div class="col-12">
                <h1 class="text-[#0078C8]">Dashboard</h1>
            </div>
        </div>
        
        <!-- Row 2: Title & Filter | Prediction Card -->
        <div class="row mb-4">
            <!-- Column 1: Title & Filter -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row align-items-center">
                                <!-- Filter Dropdown -->
                                <div class="col-md-6">
                                    <label for="filter" class="text-[#0078C8]">Filter</label>
                                    <select id="filter" class="form-control text-white" style="background-color: #0078C8;" onchange="filterComponents(this.value)">
                                        <option class="bg-white" value="" selected disabled>Pilih Bagian</option>
                                        <option class="bg-white" value="{{ url('dashboard?bagian=Plastik') }}" 
                                            @if(request('bagian') == 'Plastik') selected @endif>Plastik</option>
                                        <option class="bg-white" value="{{ url('dashboard?bagian=Logam') }}" 
                                            @if(request('bagian') == 'Logam') selected @endif>Logam</option>
                                    </select>
                                </div>
                                <!-- Sort By Dropdown -->
                                <div class="col-md-6">
                                    <label for="sortOrder" class="text-[#0078C8]">Sort By</label>
                                    <select id="sortOrder" class="form-control text-white" style="background-color: #0078C8;" onchange="changeSortOrder(this.value)">
                                        <option class="bg-white" value="" selected disabled>Pilih Urutan</option>
                                        <option class="bg-white" value="jumlah" 
                                            @if(request('sort') == 'jumlah') selected @endif>Sort by Stock</option>
                                        <option class="bg-white" value="id" 
                                            @if(request('sort') == 'id') selected @endif>Sort by ID</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Column 2: Prediction Card -->
            <div class="col-md-6">
                <div class="card text-white" style="background-color: #0078C8;">
                    <div class="card-body text-center">
                        <div class="row mb-1">
                            <!-- Left Column: Title and description -->
                            <div class="col-6 text-left">
                                <h5 class="card-title font-bold">Prediksi Produk</h5>
                                <p class="card-text">Jumlah meter air yang bisa dibuat:</p>
                            </div>
                        
                            <!-- Center Column: Number (Bold text) -->
                            <div class="col-3 text-left pt-6">
                                <h2 id="countNumber" class="font-bold ">0</h2>
                            </div>
                        
                            <!-- Right Column: Icon -->
                            <div class="col-3 text-center ">
                                <i class="fas fa-box fa-5x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Row 3: Chart -->
        <div class="row -mt-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="chart" class="text-black -mb-5"></div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Row 4: Stock Table -->
        <div class="row">
            <div class="col-12">
                <div class="card text-black">
                    <div class="card-body">
                        <h3 id="stockTitle" class="card-title text-[#0078C8] text-bold">
                            Daftar Semua Stok - {{ $bagian ?? 'Logam' }}
                        </h3>                        
                        <table class="table table-striped table-bordered custom">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">id</th>
                                    <th style="width: 50%;">Nama</th>
                                    <th style="width: 30%;">Jumlah</th>
                                    <th style="width: 10%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bagian === 'Logam')
                                    @foreach ($komponenLogam as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>
                                            @if ($item->jumlah < 600)
                                                <i class="fas fa-circle" style="color: orange; vertical-align: middle;"></i>
                                            @else
                                                <i class="fas fa-circle" style="color: green; vertical-align: middle;"></i>
                                            @endif
                                        </td>
                                    </tr>                                    
                                    @endforeach
                                @elseif ($bagian === 'Plastik')
                                    @foreach ($komponenPlastik as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>
                                            @if ($item->jumlah < 600)
                                                <i class="fas fa-circle" style="color: orange; vertical-align: middle;"></i>
                                            @else
                                                <i class="fas fa-circle" style="color: green; vertical-align: middle;"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<script>
    // JavaScript for counting animation
    document.addEventListener("DOMContentLoaded", function () {
        const targetNumber = {{ $jumlahProduk }}; // PHP variable
        const duration = 1500; // Animation duration in milliseconds (2 seconds)
        const countElement = document.getElementById("countNumber");
        
        let startTime = null;

        function animateCount(currentTime) {
            if (!startTime) startTime = currentTime;
            const elapsedTime = currentTime - startTime;

            const progress = Math.min(elapsedTime / duration, 1); // Ensure progress does not exceed 1
            const currentNumber = Math.floor(progress * targetNumber);

            countElement.textContent = currentNumber;

            if (progress < 1) {
                requestAnimationFrame(animateCount); // Continue the animation
            } else {
                countElement.textContent = targetNumber; // Ensure final number is correct
            }
        }

        requestAnimationFrame(animateCount);
    });
</script>
<script>
    function filterComponents(value) {
        window.location.href = value;  // Redirect to the selected URL (this will update the 'bagian' filter)
        }

    function changeSortOrder(value) {
        let currentUrl = new URL(window.location.href);
        let searchParams = new URLSearchParams(currentUrl.search);

        // Set the sort parameter in the URL
        searchParams.set('sort', value);

        // Update the URL without reloading the page
        currentUrl.search = searchParams.toString();
        window.history.pushState({}, '', currentUrl);
        
        // Optionally, you can reload the page if necessary
        // window.location.reload();
    }

</script>

<script>
    function filterComponents(value) {
    const url = value; // value should be a full URL including the 'bagian' query string
    window.location.href = url;
    }
</script>


<script>
    function changeSortOrder(value) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', value); // Add the sort parameter to the URL
        window.location.search = urlParams.toString(); // Reload with the new sort order
    }
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var chartData = @json($chartData);
            var bagian = @json($bagian); // Pass the 'bagian' variable from the backend to JS
    
            // Set dynamic title based on 'bagian'
            var chartTitle = 'Stok Akhir - ' + (bagian.charAt(0).toUpperCase() + bagian.slice(1)); // Capitalize first letter
    
            var options = {
                series: [{
                    name: 'Stok Akhir',
                    data: chartData.values
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                },
                plotOptions: {
                    bar: {
                        barHeight: '100%',
                        distributed: false,
                        horizontal: false,
                        borderRadius: 8,
                        borderRadiusApplication: 'end',
                        dataLabels: {
                            position: 'bottom'
                        },
                    }
                },
                legend: {
                    show: false
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#f0f2f0'],
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [20, 100]
                    }
                },
                colors: ['#0078C8'],
                dataLabels: {
                    enabled: false,
                    style: {
                        colors: ['#fff']
                    },
                    formatter: function (val, opt) {
                        return chartData.categories[opt.dataPointIndex] + ": " + val;
                    },
                    offsetX: 0,
                    dropShadow: {
                        enabled: true
                    }
                },
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: chartData.categories,
                    labels: {
                        show: true
                    }
                },
                yaxis: {
                    labels: {
                        show: true
                    }
                },
                title: {
                    text: chartTitle, // Use dynamic title here
                    align: 'left',
                    floating: true,
                    style: {
                        color: '#0078C8'
                    }
                },
                tooltip: {
                    theme: 'light',
                    x: {
                        show: true
                    },
                    y: {
                        title: {
                            formatter: function () {
                                return ''
                            }
                        }
                    }
                }
            };
    
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endsection