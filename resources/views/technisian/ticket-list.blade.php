@extends('layouts.tech-app')

@section('title', 'Tasks')

@section('header', 'Daftar Tiket')

@section('content')
<style>
        table tbody tr {
        background-color: #fefefe;
        color: #000000;
        border-bottom: 1px solid #ffffff;
    }
</style>
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
    <div class="card-header bg-danger"></div>
    <div class="card-body">
<table id="tech-table" class="table">
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
        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-primary">
                    <a href="{{ route('detail-tiket', $ticket->id) }}">
                        {{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                    </a>
                </td>
                <td>{{ $ticket->created_at->format('d F Y') }}</td>
                <td>{{ $ticket->subjek ?? 'Tanpa Judul' }}</td>
                <td>{{ $ticket->satkerData->nama_satker ?? 'Tanpa Satker' }}</td>
                <td>{{ $ticket->prioritas ?? 'Tanpa Prioritas' }}</td>
                <td>{{ $ticket->status_id == 1 ? 'Menunggu' : ($ticket->status_id == 2 ? 'Diproses' : ($ticket->status_id == 4 ? 'Proses Selesai' : 'Selesai')) }}</td>
                <td>{{ $ticket->user->name ?? 'Tanpa Nama' }}</td>
                <td>
                    @if ($ticket->status_id == 1)
                        <form method="POST" action="{{ route('update-technisian', $ticket->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Proses</button>
                        </form>
                    @else 
                        <a href="{{ route('detail-tiket', $ticket->id) }}" class="btn btn-primary btn-sm">Detail</a>
                    @endif
                </td>                
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>

@endsection