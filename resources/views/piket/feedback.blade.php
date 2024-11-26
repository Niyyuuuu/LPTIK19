@extends('layouts.piket-app')

@section('header', 'Feedback Report' )

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
</style>
@endpush

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
        <table id="piket-table" class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Tiket</th>
                    <th>Subjek</th>
                    <th>Pelapor</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-center">Rating</th>
                    <th>Komentar</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($ratingticket as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-warning">
                            <a href="{{ route('detail-tiket', $ticket->id) }}">
                                {{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                            </a>
                        </td>
                        <td>{{ $ticket->subjek ?? 'Tanpa Judul' }}</td>
                        <td>{{ $ticket->user->name ?? 'Tanpa Nama' }}</td>
                        <td>{{ $ticket->created_at->format('d M Y') }}</td>
                        <td class="text-center">@if ($ticket->rating) @for ($i = 0; $i < $ticket->rating; $i++) <i class='bx bxs-star text-warning'></i> @endfor @else Rating tidak tersedia. @endif</td>
                        <td>{{ $ticket->rating_comment ?? 'Komentar tidak tersedia.' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endSection