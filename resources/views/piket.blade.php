@extends('layouts.piket-app')

@section('header', 'Dashboard Piket' )

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
        }

        .card-body {
            background-color: #1e1e1e;
        }
    </style>
@endpush

@section('content')
@if(session('success'))
    <div class="message-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="message-error">{{ session('error') }}</div>
@endif
<div class="container">
    <h2>Selamat Datang di Dashboard, {{ Auth::user()->name }}</h2>
    <br>
    <div class="row mb-4">
        <div>
            <form method="GET" action="{{ route('piket') }}">
                <div class="input-group mb-2">
                    <label class="input-group-text bg-dark text-light border-primary" for="filterYear">Tahun</label>
                    <select class="form-select bg-dark text-light border-primary" id="filterYear" name="year">
                        <!-- Year options will be populated by JavaScript -->
                    </select>
                </div>
    
                <div class="input-group mb-2">
                    <label class="input-group-text bg-dark text-light border-primary" for="startDate">Start Date</label>
                    <input type="date" class="form-control bg-dark text-light border-primary" name="start_date" id="startDate">
                </div>
    
                <div class="input-group mb-2">
                    <label class="input-group-text bg-dark text-light border-primary" for="endDate">End Date</label>
                    <input type="date" class="form-control bg-dark text-light border-primary" name="end_date" id="endDate">
                </div>
    
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>    

    <h3 class="mb-4">Total Tiket</h3>
    <div class="d-flex justify-content-start w-25">
        <div class="card mb-4 flex-fill">
            <div class="card-header text-center">Total Tiket</div>
            <div class="card-body">
                <h5 class="text-center mt-2 fs-1">{{ $totalTickets }}</h5>
            </div>
        </div>
    </div>

    @foreach (['status' => 'Status Tiket', 'prioritas' => 'Prioritas', 'area' => 'Area'] as $key => $label)
        <h3 class="mb-4">{{ $label }}</h3>
        <div class="row mb-4">
            @foreach ($counts[$key] as $type => $count)
                <div class="col d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">{{ ucfirst($type) }}</div>
                        <div class="card-body">
                            <h5 class="text-center mt-2 fs-1">{{ $count }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
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
