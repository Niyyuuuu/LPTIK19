<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Tiket</title>
    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/png">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa; /* Light background for better contrast */
        }
        .card-header {
            background-color: #007bff; /* Primary color for header */
            color: white;
        }
        .table th {
            background-color: #e9ecef; /* Light gray background for table headers */
        }
    </style>
</head>
<body>
    <nav class="navbar bg-body-dark">
        <form class="container-fluid justify-content-left mt-4 ms-2">
          <button onclick="history.back()" class="btn btn-outline-danger me-2" type="button">Back</button>
        </form>
    </nav>
    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">Detail Tiket</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover mt-3">
                    <tr>
                        <th style="width: 20%;">Subjek</th>
                        <td>{{ $tiket->subjek }}</td>
                    </tr>
                    <tr>
                        <th>Permasalahan</th>
                        <td>{{ $tiket->permasalahan }}</td>
                    </tr>
                    <tr>
                        <th>Satker</th>
                        <td>{{ $tiket->satkerData->nama_satker ?? 'Satker tidak ditemukan' }}</td>
                    </tr>               
                    <tr>
                        <th>Prioritas</th>
                        <td>{{ $tiket->prioritas }}</td>
                    </tr>
                    <tr>
                        <th>Area Laporan</th>
                        <td>{{ $tiket->area }}</td>
                    </tr>
                    <tr>
                        <th>Pesan</th>
                        <td>{{ $tiket->pesan }}</td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>
                            @if ($tiket->lampiran)
                                @php
                                    $filePath = str_replace('public/', '', $tiket->lampiran);
                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    $filename = 'Lampiran.' . $extension;
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                                    $isPDF = $extension === 'pdf';
                                @endphp
                                
                                <!-- Show Image or PDF Preview -->
                                @if ($isImage)
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $filePath) }}" alt="Lampiran" style="max-width: 200px; max-height: 200px;">
                                    </a>
                                @elseif ($isPDF)
                                    <embed src="{{ asset('storage/' . $filePath) }}" type="application/pdf" width="100%" height="400px" />
                                @endif
                    
                                <!-- Always show the download button -->
                                <br>
                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" download="{{ $filename }}">Download {{ $filename }}</a>
                    
                            @else
                                <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </td>
                    </tr>
                    
                    
                </table>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">Diskusi</h5>
            </div>
            <div class="card-body">
                
            </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
