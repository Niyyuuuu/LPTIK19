<!-- technisi.blade.php -->
@extends('layouts.tech-app')

@section('title', 'Technician Dashboard')

@section('header', 'Dashboard Teknisi' )
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
            background-color: #712121;
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
<div class="message-success">{{ session('success') }}</div>
@endif
        <h2>Selamat Datang di Dashboard, {{ Auth::user()->name }}</h2>
        <div class="row mb-4">
            <div>
                <form method="GET" action="{{ route('technician') }}">
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


        <h3 class="mb-4">Status Tiket</h3>
        <div class="d-flex gap-4 mb-4">
            @foreach ($counts['status_id'] as $statusId => $count)
                <div class="col d-flex">
                    <a href="{{ route('card-tickets', ['category' => 'status_id', 'value' => $statusId]) }}" class="text-decoration-none w-100">
                        <div class="card flex-fill">
                            <div class="card-header">{{ $statusLabels[$statusId] }}</div>
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
                            <div class="card-header">{{ ucfirst($type) }}</div>
                            <div class="card-body">
                                <h5 class="text-center mt-2 fs-1">{{ $count }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
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
@endsection
