@extends('layouts.piket-app')

@section('header', 'Ticket List')

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
            font-weight: 500;
            font-size: 1.2rem;
        }

        .card-body {
            background-color: #1e1e1e;
        }

        table thead {
            background-color: #2c2c2c;
            color: #fff;
        }

        table tbody tr {
            background-color: #1e1e1e;
            border-bottom: 1px solid #2c2c2c;
        }

        table tbody tr:hover {
            background-color: #333;
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

<div class="card">
    <div class="card-header bg-primary bx bxs-file"></div>
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
                <td class="text-warning">
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
                            <i class="bx bx-cog"></i> Proses
                        </a>
                        <a href="{{ route('edit-tickets', $item->id) }}" class="btn btn-warning" title="Edit">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                    @elseif ($item->status_id == 4 || $item->status_id == 2)
                        <form action="{{ route('tutup-tiket', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menutup tiket ini?')" title="Close">
                                <i class="bx bx-x-circle"></i> Tutup
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
    <div class="card-header bg-primary bx bxs-file"></div>
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
                    <td class="text-warning">
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
                                    <i class="bx bx-trash"></i> Delete
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
