@extends('layouts.tech-app')

@section('title', 'Tasks')

@section('header', 'Daftar Tiket')

@section('content')

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
<table id="tech-table" class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>No. Tiket</th>
            <th>Subjek</th>
            <th>Pelapor</th>
            <th>Status</th>
            <th>Tanggal Dibuat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-warning">
                    <a href="{{ route('detail-tiket', $ticket->id) }}">
                        {{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                    </a>
                </td>
                <td>{{ $ticket->subjek ?? 'Tanpa Judul' }}</td>
                <td>{{ $ticket->user->name ?? 'Tanpa Nama' }}</td>
                <td>{{ $ticket->status ?? 'Deskripsi tidak tersedia.' }}</td>
                <td>{{ $ticket->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>

@endsection