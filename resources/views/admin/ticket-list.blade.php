@extends('layouts.admin-app')

@section('title', 'List Ticket')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">List Ticket</h1>

    <div>
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
            <table id="admin-table" class="table">
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
                        <td>
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
                            <a href="{{ route('ticket.process', $item->id) }}" class="btn btn-primary">Process</a>
                            @if ($item->status !== 'Ditutup' && $item->status !== 'Selesai')
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
</div>
@endsection


