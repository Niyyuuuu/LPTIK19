@extends('layouts.piket-app')

@section('header', 'Ticket List')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .card {
            color: #000000;
            min-height: 150px;
            border-radius: 5px;
            box-shadow: 0 0 .6rem rgb(80, 80, 80);
        }

        .card-header {
            font-weight: 500;
            font-size: 1.2rem;
        }
        
        table tbody tr {
            background-color: #fefefe;
            color: #000000;
            border-bottom: 1px solid #ffffff;
        }
        
        .btn-primary, .btn-warning, .btn-danger {
            padding: 0.4rem 0.75rem;
            font-size: 0.875rem;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
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

<div class="card mb-4">
    <div class="card-header bg-primary"></div>
    <div class="card-body"> <table id="piket-table" class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Tiket</th>
                <th>Tanggal</th>
                <th>Subjek</th>
                <th>Satker</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Pelapor</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody> @foreach($filteredTickets as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-primary">
                    <a href="{{ route('detail-tiket', $item->id) }}"> {{ str_pad($item->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}</a>
                </td>
                <td>{{ $item->created_at->format('d F Y') }}</td>
                <td>{{ $item->subjek }}</td>
                <td>{{ $item->satkerData->nama_satker }}</td>
                <td>{{ $item->prioritas }}</td>
                <td>{{ $item->status_id == 1 ? 'Menunggu' : ($item->status_id == 2 ? 'Diproses' : ($item->status_id == 4 ? 'Proses Selesai' : 'Selesai')) }}</td>
                <td>{{ $item->user->name }}</td>
                <td class="table-actions justify-content-center">
                    @if ($item->status_id == 1)
                        <a href="{{ route('process-ticket', $item->id) }}" class="btn btn-primary" title="Process">
                            Proses
                        </a>
                        <a href="{{ route('edit-tickets', $item->id) }}" class="btn btn-warning" title="Edit">
                            Edit
                        </a>
                    @elseif ($item->status_id == 4 || $item->status_id == 2)
                        <form action="{{ route('tutup-tiket', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menutup tiket ini?')" title="Close">
                            Tutup
                            </button>
                        </form>
                    @endif
                </td>                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary"></div>
    <div class="card-body">
        <table id="piket1-table" class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Tiket</th>
                    <th>Tanggal</th>
                    <th>Subjek</th>
                    <th>Satker</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Pelapor</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allTickets as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-primary">
                        <a href="{{ route('detail-tiket', $item->id) }}">
                            {{ str_pad($item->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                        </a>
                    </td>
                    <td>{{ $item->created_at->format('d F Y') }}</td>
                    <td>{{ $item->subjek }}</td>
                    <td>{{ $item->satkerData->nama_satker }}</td>
                    <td>{{ $item->prioritas }}</td>
                    <td>{{ $item->status_id == 1 ? 'Menunggu' : ($item->status_id == 2 ? 'Diproses' : ($item->status_id == 4 ? 'Proses Selesai' : 'Selesai')) }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td class="table-actions justify-content-center">
                        @if ($item->status_id == 3)
                            <form action="{{ route('hapus-tiket', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Delete">
                                    Delete
                                </button>
                            </form>
                        @else
                            -
                        @endif
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
