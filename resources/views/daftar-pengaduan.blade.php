<!-- resources/views/daftar-pengaduan.blade.php -->
@extends('layouts.app')

@section('title', 'Daftar Pengaduan')

@section('content')
    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div>
        <h1 class="fw-bold text-center mt-3 mb-5">Daftar Pengaduan</h1>
    </div>
    <div>
        <a href="{{ route('buat-pengaduan') }}" class="btn btn-success mb-4">Buat Pengaduan</a>
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
    <div class="table-responsive">
    <table id="tiket-table" class="table table-bordered mt-3 mb-5">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Tiket</th>
                <th>Tanggal</th>
                <th>Subjek</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($tiket as $t)
                @if ($t->status_id != 3)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <a href="{{ route('detail-tiket', $t->id) }}">
                                {{ str_pad($t->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}
                            </a>
                        </td>
                        <td>{{ date('d F Y', strtotime($t->created_at)) }}</td>
                        <td>{{ $t->subjek }}</td>
                        <td>{{ $t->prioritas }}</td>
                        <td>
                            {{ 
                                $t->status_id == 1 ? 'Menunggu' : 
                                ($t->status_id == 2 ? 'Diproses' : 
                                ($t->status_id == 4 ? 'Proses Selesai' : 'Belum Selesai'))
                            }}
                        </td>                        
                        <td class="text-center">
                            @if ($t->status_id == 1)
                            <a href="{{ route('edit-pengaduan', $t->id) }}" class="btn btn-warning">Edit</a>
                            @endif
                            <form action="{{ route('tutup-tiket', $t->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menutup tiket ini?')">Tutup</button>
                            </form>
                        </td>                            
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endif
            @endforeach
        </tbody>
    </table>
    </div>
    <style>
    @media (max-width: 576px) {
        #tiket-table thead th:nth-child(3), /* Tanggal */
        #tiket-table thead th:nth-child(5) { /* Prioritas */
            display: none;
        }
        
        #tiket-table td:nth-child(3), /* Tanggal */
        #tiket-table td:nth-child(5) { /* Prioritas */
            display: none;
        }
    }
    </style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tiket-table').DataTable({
            language: {
                lengthMenu: "Tampilkan _MENU_ tiket per halaman",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada entri tersedia",
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

        const hamBurger = document.querySelector(".toggle-btn");
        hamBurger.addEventListener("click", function() {
            document.querySelector("#sidebar").classList.toggle("expand");
        });
    });
</script>
@endpush
