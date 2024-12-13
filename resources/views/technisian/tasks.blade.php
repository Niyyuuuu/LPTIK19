@extends('layouts.tech-app')

@section('title', 'Tasks')

@section('header', 'Daftar Tugas')

@section('content')

<style>
            table tbody tr {
            background-color: #fefefe;
            color: #000000;
            border-bottom: 1px solid #ffffff;
        }
</style>
@if (session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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

@if($tickets->isEmpty())
<p class="no-tickets-message">Tidak ada tiket yang tersedia.</p>
@else
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
                            <th>Aksi</th>
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
                                <td>{{ $ticket->user->name ?? 'Tanpa Nama' }}</td>
                                <td>{{ $ticket->status_id == 2 ? 'Diproses' : ($ticket->status_id == 4 ? 'Selesai' : '') }}</td>
                                <td>
                                    @if($ticket->status_id == 2)
                                        <a href="{{ route('tutup-tiket-teknisi' , $ticket->id) }}" class="btn btn-danger btn-sm" onclick="return confirmClosure(event, '{{ $ticket->id }}')">
                                            Tutup
                                        </a>
                                    @endif
                                </td>                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function confirmClosure(event, ticketId) {
                event.preventDefault();
                const confirmation = confirm("Apakah Anda yakin ingin menutup tiket ini?");
                if (confirmation) {
                    window.location.href = "{{ url('tutup-tiket-teknisi') }}/" + ticketId;
                }
            }
        </script>        
    @endif
@endsection
