<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Tiket</title>
    
    <!-- Import CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Inline Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        /* Global Styles */
        body {
            background-color: #121212;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        /* Card Styling */
        .card {
            background-color: #1e1e1e;
            border: none;
            border-radius: 10px;
        }

        .card-header {
            background-color: #0066ff;
            color: #fff;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        /* Table Styling */
        .table {
            width: 100%;
            margin-bottom: 20px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #2b2b2b;
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #1e1e1e;
        }

        .table-striped tbody tr:hover {
            background-color: #444;
        }

        .table thead th {
            background-color: #3a3a3a;
            color: #fff;
            border-bottom: 1px solid #444;
            text-align: left;
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_paginate label, {
            color: #fff;
        }

        /* Button Styling */
        .btn-back {
            margin-top: 1rem;
            background-color: #ef4444;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-back:hover {
            background-color: #d32f2f;
        }

        /* Links */
        a {
            color: #ffffff;
            text-decoration: none;
        }

        a:hover {
            color: #0a58ca;
        }
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            background: none !important;
        }

    </style>
</head>
<body>
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

    <div class="container">
        <h1 class="mb-4 text-center">Tiket {{ ucfirst($status) }}</h1>

        @if($tickets->isEmpty())
            <p class="text-muted text-center">Tidak ada tiket dengan status {{ $status }}.</p>
        @else
        <div class="card">
            <div class="card-header"><i class="bx bxs-file"></i> Daftar Tiket</div>
            <div class="card-body">
                <table id="ticket-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Tiket</th>
                            <th>Subjek</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('detail-tiket', $ticket->id) }}" class="link-primary">
                                    {{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                                </a>
                            </td>
                            <td>{{ $ticket->subjek }}</td>
                            <td>{{ $ticket->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <button onclick="history.back()" class="btn btn-back">Kembali</button>
    </div>

    <!-- Import JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ticket-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                language: {
                    lengthMenu: "Tampilkan _MENU_ entri per halaman",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada entri yang tersedia",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
</body>
</html>
