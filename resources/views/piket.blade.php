@extends('layouts.piket-app')

@section('header', 'Dashboard Piket' )

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

        body {
            background-color: #f8f9fa;
            color: #343a40;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            min-height: 150px;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-header {
            background-color: #214471;
            color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 10px;
        }
        .card a { 
            text-decoration: none; 
            color: inherit;
        }
        .card:hover { 
            transform: scale(1.01);
            box-shadow: 0 0 .6rem rgba(91, 91, 91, 0.6);
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .form-select, .form-control {
            background-color: #ffffff;
            color: #343a40;
            border: 1px solid #ced4da;
        }

        .form-select:focus, .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group-text {
            background-color: #e9ecef;
            color: #495057;
            border: 1px solid #ced4da;
        }
    </style>
@endpush

@section('content')
@if(session('success'))
    <div class="message-success text-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="message-error text-danger">{{ session('error') }}</div>
@endif
<h2>Selamat Datang di Dashboard, {{ Auth::user()->name }}</h2>
    <br>
    <div class="row mb-4">
        <div>
            <form method="GET" action="{{ route('piket') }}">
                <div class="input-group mb-2">
                    <label class="input-group-text" for="filterYear">Tahun</label>
                    <select class="form-select" id="filterYear" name="year">
                    </select>
                </div>

                <div class="input-group mb-2">
                    <label class="input-group-text" for="startDate">Start Date</label>
                    <input type="date" class="form-control" name="start_date" id="startDate">
                </div>

                <div class="input-group mb-2">
                    <label class="input-group-text" for="endDate">End Date</label>
                    <input type="date" class="form-control" name="end_date" id="endDate">
                </div>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>    

    <h3 class="mb-4">Total Tiket</h3>
    <div class="d-flex justify-content-start w-25">
        <div class="card mb-4 flex-fill">
            <a href="{{ route('tickets') }}">
            <div class="card-header text-center">Total Tiket</div>
            <div class="card-body">
                <h5 class="text-center mt-2 fs-1">{{ $totalTickets }}</h5>
            </div>
            </a>
        </div>
    </div>

    <h3 class="mb-4">Status Tiket</h3>
    <div class="row mb-4">
        @foreach ($counts['status_id'] as $statusId => $count)
            <div class="col d-flex">
                <a href="{{ route('card-tickets', ['category' => 'status_id', 'value' => $statusId]) }}" class="text-decoration-none w-100">
                    <div class="card flex-fill">
                        <div class="card-header text-center">{{ $statusLabels[$statusId] }}</div>
                        <div class="card-body">
                            <h5 class="text-center mt-2 fs-1">{{ $count }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @foreach (['prioritas' => 'Prioritas', 'area' => 'Area'] as $key => $label)
        <h3 class="mb-4">{{ $label }}</h3>
        <div class="row mb-4">
            @foreach ($counts[$key] as $type => $count)
                <div class="col d-flex">
                    <a href="{{ route('card-tickets', ['category' => $key, 'value' => strtolower($type)]) }}" class="text-decoration-none w-100">
                        <div class="card flex-fill">
                            <div class="card-header text-center">{{ ucfirst($type) }}</div>
                            <div class="card-body">
                                <h5 class="text-center mt-2 fs-1">{{ $count }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach

<div id="statusChart" style="width: 100%; height: 400px;margin-bottom: 2rem;"></div>
<div id="priorityChart" style="width: 100%; height: 400px;margin-bottom: 2rem;"></div>
<div id="areaChart" style="width: 100%; height: 400px;margin-bottom: 2rem;"></div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Status Chart
    Highcharts.chart('statusChart', {
        chart: {
            type: 'column',
            backgroundColor: '#ffffff',
            borderRadius: 10
        },
        title: {
            text: 'Status Tiket',
            color: '#000',
            style: { color: '#000', fontFamily: 'Poppins, sans-serif' }
        },
        xAxis: {
            categories: ['Menunggu', 'Diproses', 'Proses Selesai', 'Selesai'],
            labels: {
                style: { color: '#000', fontFamily: 'Poppins, sans-serif' }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Tiket',
                style: { color: '#000', fontFamily: 'Poppins, sans-serif' }
            }
        },
        series: [{
            name: 'Tiket',
            data: [
                {{ $counts['status_id'][1] }},
                {{ $counts['status_id'][2] }},
                {{ $counts['status_id'][3] }},
                {{ $counts['status_id'][4] }}
            ]
        }],
        colors: ['#536493', '#FFF1DB', '#EF5A6F', '#9FA2B3'],
        credits: { enabled: false }
    });

    // Priority Chart
    Highcharts.chart('priorityChart', {
        chart: {
            type: 'pie',
            backgroundColor: '#fff',
            borderRadius: 10
        },
        title: {
            text: 'Prioritas Tiket',
            style: { color: '#fff', fontFamily: 'Poppins, sans-serif' }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}'
                }
            }
        },
        series: [{
        name: 'Prioritas',
        colorByPoint: true,
        data: [
            { name: 'Tinggi', y: {{ $counts['prioritas']['tinggi'] }} },
            { name: 'Sedang', y: {{ $counts['prioritas']['sedang'] }} },
            { name: 'Rendah', y: {{ $counts['prioritas']['rendah'] }} }
        ]
    }],
    colors: ['#536493', '#FFF1DB', '#EF5A6F'],
    credits: { enabled: false }

    });

    // Area Chart
    Highcharts.chart('areaChart', {
        chart: {
            type: 'bar',
            backgroundColor: '#fff',
            borderRadius: 10
        },
        title: {
            text: 'Area Tiket',
            style: { color: '#fff', fontFamily: 'Poppins, sans-serif' }
        },
        xAxis: {
            categories: ['Kemhan', 'Luar Kemhan'],
            labels: {
                style: { color: '#fff', fontFamily: 'Poppins, sans-serif' }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Tiket',
                style: { color: '#fff', fontFamily: 'Poppins, sans-serif' }
            }
        },
        series: [{
            name: 'Tiket',
            data: [
                {{ $counts['area']['Kemhan'] }},
                {{ $counts['area']['Luar Kemhan'] }}
            ]
        }],
        colors: ['#536493', '#EF5A6F'],
        credits: { enabled: false }
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('filterYear');
    const currentYear = new Date().getFullYear();
    for (let year = currentYear; year >= currentYear - 5; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }
});
</script>
@endpush
