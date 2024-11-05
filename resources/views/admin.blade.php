{{-- admin.blade.php --}}
@extends('layouts.admin-app')

@section('title', 'Dashboard')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

        body {
            background-color: #161616;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            background-color: #1e1e1e;
            color: #fff;
            border: none;
            min-height: 150px;
            border-radius: 10px;
        }

        .card-header {
            background-color: #2c2c2c;
            border-bottom: none;
            color: #fff;
        }

        .card-body {
            background-color: #1e1e1e;
            border-radius: 0 0 6px 6px;
        }

        .highcharts-container {
            background-color: #1e1e1e;
            border-radius: 10px;
        }

        /* Ensure the chart takes full width */
        .chart-full-width {
            width: 100%;
            height: auto;
        }

        h1, h3 {
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        
        <h1 class="mb-4">Dashboard</h1>
        
<!-- Filter Tahun -->
<div class="row mb-4">
    <div class="col-md-4">
        <form method="GET" action="{{ route('admin') }}">
            <div class="input-group">
                <label class="input-group-text bg-dark text-light border-primary" for="filterYear">Tahun</label>
                <select class="form-select bg-dark text-light border-primary" id="filterYear" name="year">
                    @foreach (range(2022, date('Y') + 2) as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

        <h3 class="mb-4">Total Users</h3>
        <div class="d-flex justify-content-start w-25">
            <div class="card mb-4 flex-fill">
                <div class="card-header text-center">Total Users</div>
                <div class="card-body">
                    <h5 class="text-center mt-2 fs-1">{{ $total_users }}</h5>
                </div>
            </div>
        </div>                

        <h3 class="mb-4">Status</h3>
        <div class="d-flex gap-4 mb-4">
            @foreach (['Diproses', 'Selesai', 'Ditutup'] as $status)
                <div class="col d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">{{ $status }}</div>
                        <div class="card-body">
                            <h5 class="text-center mt-2 fs-1">{{ $counts['status'][strtolower($status)] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <h3 class="mb-4">Prioritas</h3>
        <div class="row mb-4">
            @foreach (['Tinggi', 'Sedang', 'Rendah'] as $prioritas)
                <div class="col d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">{{ $prioritas }}</div>
                        <div class="card-body">
                            <h5 class="text-center mt-2 fs-1">{{ $counts['prioritas'][strtolower($prioritas)] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="mb-4">Area</h3>
        <div class="row mb-4">
            @foreach (['Kemhan', 'Luar Kemhan'] as $area)
                <div class="col d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">{{ $area }}</div>
                        <div class="card-body">
                            <h5 class="text-center mt-2 fs-1">{{ $counts['area'][$area] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- **New: Complaints Per Year Chart** --}}
        <h3 class="mb-4">Jumlah Pengaduan Per Tahun</h3>
        <div class="row mb-4">
            <div class="col d-flex">
                <div class="card flex-fill">
                    <div class="card-header">Pengaduan Pertahun {{ $selectedYear }}</div>
                    <div class="card-body">
                        <div id="chart-complaints-year" class="chart-full-width"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach (['prioritas', 'permasalahan', 'rating', 'area'] as $chart)
                <div class="col-md-6 d-flex">
                    <div class="card mb-4 flex-fill">
                        <div class="card-header">Chart {{ ucfirst($chart) }}</div>
                        <div class="card-body">
                            <div id="chart-{{ $chart }}"></div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Satker Chart with Full Width -->
            <div class="col-12 d-flex">
                <div class="card mb-4 flex-fill">
                    <div class="card-header">Chart Satker</div>
                    <div class="card-body">
                        <div id="chart-satker" class="chart-full-width"></div> <!-- Add a specific class for styling -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        const chartData = {
            prioritas: {
                type: 'pie',
                data: [
                    { name: 'Tinggi', y: {{ $counts['prioritas']['tinggi'] }}, color: '#536493' },
                    { name: 'Sedang', y: {{ $counts['prioritas']['sedang'] }}, color: '#FFF1DB' },
                    { name: 'Rendah', y: {{ $counts['prioritas']['rendah'] }}, color: '#EF5A6F' },
                ]       
            },
            permasalahan: {
                type: 'column',
                categories: ['Jaringan', 'Software', 'Hardware'],
                data: [{{ $counts['permasalahan']['jaringan'] }}, {{ $counts['permasalahan']['software'] }}, {{ $counts['permasalahan']['hardware'] }}],
                showDataLabels: false // Disable data labels for column chart
            },
            rating: {
            type: 'pie',
            data: [
                {name: 'Rating 1',y: {{ $counts['rating'][1] ?? 0 }},color: '#EF5A6F'},
                {name: 'Rating 2',y: {{ $counts['rating'][2] ?? 0 }},color: '#F7A6A5'},
                {name: 'Rating 3',y: {{ $counts['rating'][3] ?? 0 }},color: '#FFF1DB'},
                {name: 'Rating 4',y: {{ $counts['rating'][4] ?? 0 }},color: '#9FA2B3'},
                {name: 'Rating 5',y: {{ $counts['rating'][5] ?? 0 }},color: '#536493'}
            ]},
            area: {
                type: 'pie',
                data: [
                    { name: 'Kemhan', y: {{ $counts['area']['Kemhan'] }}, color: '#536493' },
                    { name: 'Luar Kemhan', y: {{ $counts['area']['Luar Kemhan'] }}, color: '#EF5A6F' }
                ]
            },
            satker: {
                type: 'column',
                categories: {!! json_encode($nama_satker->pluck('satkerData.nama_satker')->toArray()) !!},
                data: {!! json_encode($nama_satker->pluck('count')->toArray()) !!},
                showDataLabels: false
            },
            complaintsYear: { 
        type: 'column',
        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        series: [
            {
                name: 'Diproses',
                data: [{{ implode(',', $complaintsPerMonth['diproses']) }}],
                color: '#536493'
            },
            {
                name: 'Selesai',
                data: [{{ implode(',', $complaintsPerMonth['selesai']) }}],
                color: '#FFF1DB'
            },
            {
                name: 'Ditutup',
                data: [{{ implode(',', $complaintsPerMonth['ditutup']) }}],
                color: '#EF5A6F'
            }
        ],
        showDataLabels: false
    }
        };
    
        Object.keys(chartData).forEach(chartKey => {
            if(chartKey === 'complaintsYear') {
                // **New: Render Complaints Per Year Chart**
                Highcharts.chart('chart-complaints-year', {
    chart: { 
        type: chartData.complaintsYear.type, 
        backgroundColor: '#1e1e1e',
        borderRadius: 10
    },
    title: { 
        text: 'Jumlah Pengaduan Bulanan Tahun {{ $selectedYear }}', 
        style: { color: '#fff', fontFamily: 'Poppins, sans-serif' }
    },
    xAxis: { 
        categories: chartData.complaintsYear.categories, 
        labels: { style: { color: '#fff', fontFamily: 'Poppins, sans-serif' } }
    },
    yAxis: { 
        title: { text: 'Jumlah', style: { color: '#fff', fontFamily: 'Poppins, sans-serif' } }, 
        labels: { style: { color: '#fff', fontFamily: 'Poppins, sans-serif' } }
    },
    series: chartData.complaintsYear.series,
    plotOptions: {
        column: {
            dataLabels: {
                enabled: chartData.complaintsYear.showDataLabels ?? true,
                color: '#fff',
                style: { fontFamily: 'Poppins, sans-serif' }
            }
        }
    },
    legend: { 
        enabled: true 
    },
    credits: { enabled: false },
    tooltip: {
        style: { color: '#000', fontFamily: 'Poppins, sans-serif' }
    }
});
            } else {
                Highcharts.chart(`chart-${chartKey}`, {
                    chart: { 
                        type: chartData[chartKey].type, 
                        backgroundColor: '#1e1e1e',
                        borderRadius: 10
                    },
                    title: { 
                        text: `${chartKey.charAt(0).toUpperCase() + chartKey.slice(1)} Tiket`, 
                        style: { color: '#fff', fontFamily: 'Poppins, sans-serif' }
                    },
                    xAxis: { 
                        categories: chartData[chartKey].categories || [], 
                        labels: { style: { color: '#fff', fontFamily: 'Poppins, sans-serif' } }
                    },
                    yAxis: { 
                        title: { text: 'Jumlah', style: { color: '#fff', fontFamily: 'Poppins, sans-serif' } }, 
                        labels: { style: { color: '#fff', fontFamily: 'Poppins, sans-serif' } }
                    },
                    series: [{
                        name: 'Jumlah',
                        data: chartData[chartKey].data,
                        // For pie charts, color is handled per data point
                        color: chartData[chartKey].type === 'pie' ? undefined : '#FFF1DB',
                        dataLabels: {
                            enabled: chartData[chartKey].showDataLabels ?? true, // Disable data labels for certain charts
                            color: '#fff',
                            style: { fontFamily: 'Poppins, sans-serif' }
                        }
                    }],
                    legend: { 
                        enabled: chartData[chartKey].type === 'pie' ? true : false 
                    },
                    credits: { enabled: false },
                    plotOptions: chartData[chartKey].type === 'pie' ? {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y}',
                                style: {
                                    color: '#fff',
                                    fontFamily: 'Poppins, sans-serif'
                                }
                            }
                        }
                    } : {}
                });
            }
        });
    </script>    
@endpush
