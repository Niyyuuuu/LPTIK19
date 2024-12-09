<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Tiket</title>
    
    <!-- Import CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">

    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}">

    <!-- Inline Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: Poppins, sans-serif;
            background-color: #1a1a1a;
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

    <div class="container mt-5 p-5 bg-light rounded">
        <!-- Ubah nama kategori status_id menjadi "Status" -->
        <h1 class="mb-4">{{ $category === 'status_id' ? 'Status' : ucfirst($category) }} Tiket: 
            {{ $category === 'status_id' ? ($value == 1 ? 'Menunggu' : ($value == 2 ? 'Diproses' : ($value == 3 ? 'Selesai' : ucfirst($value)))) : ucfirst($value) }}
        </h1>

        @if($tickets->isEmpty())
            <!-- Perbarui teks untuk kategori status_id -->
            <p class="text-muted">Tidak ada tiket dengan kategori {{ $category === 'status_id' ? 'Status' : ucfirst($category) }} 
                {{ $category === 'status_id' ? ($value == 1 ? 'Menunggu' : ($value == 2 ? 'Diproses' : ($value == 3 ? 'Selesai' : ucfirst($value)))) : ucfirst($value) }}.
            </p>
        @else
            <table id="ticket-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Tiket</th>
                        <th>Subjek</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th>Area</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('detail-tiket', $ticket->id) }}">
                                {{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                            </a>
                        </td>
                        <td>{{ $ticket->subjek }}</td>
                        <td>
                            @switch($ticket->status_id)
                                @case(1)
                                    Menunggu
                                    @break
                                @case(2)
                                    Diproses
                                    @break
                                @case(3)
                                    Selesai
                                    @break
                                @default
                                    Tidak Diketahui
                            @endswitch
                        </td>
                        <td>{{ $ticket->prioritas }}</td>
                        <td>{{ $ticket->area }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <button onclick="history.back()" class="btn-back btn btn-primary">Kembali</button>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ticket-table').DataTable({
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