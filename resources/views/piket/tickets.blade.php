@extends('layouts.piket-app')

@section('header', 'Ticket List' )

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

<div class="mt-4">
    <a href="{{ route('buat-pengaduan') }}" class="btn btn-success mb-4">Add New Ticket</a>
</div>

@php
    function toRoman($month) {
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        return $romanMonths[$month] ?? '';
    }
@endphp

<div class="card">
    <div class="card-header bg-primary bx bxs-file"></div>
    <div class="card-body">
        <table id="piket-table" class="table">
            <thead>
                <tr>
                    <th>No. Tiket</th>
                    <th>Subjek</th>
                    <th>Permasalahan</th>
                    <th>Satker</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tiket as $item)
                <tr>
                    <td class="text-warning">
                        <a href="{{ route('detail-tiket', $item->id) }}">
                            {{ str_pad($item->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                        </a>
                    </td>
                    <td>{{ $item->subjek }}</td>
                    <td>{{ $item->permasalahan }}</td>
                    <td>{{ $item->satkerData->nama_satker }}</td>
                    <td>{{ $item->prioritas }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td class="gap-2-xl justify-content-end text-end">
                        <a href="{{ route('process-ticket', $item->id) }}" class="btn btn-primary">Process</a>
                        @if ($item->status !== 'Ditutup' && $item->status !== 'Selesai')
                            <form action="{{ route('edit-tickets', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="btn btn-warning">Update</button>
                            </form>
                            <form action="{{ route('tutup-tiket', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menutup tiket ini?')">Tutup</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection