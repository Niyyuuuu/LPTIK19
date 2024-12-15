@extends('layouts.app')

@section('title', 'Riwayat Pengaduan')

@section('content')
    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <h1 class="fw-bold text-center mt-3 mb-5">Riwayat Pengaduan</h1>
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
                @php $i = 1; @endphp
                @foreach ($tiket as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('detail-tiket', $t->id) }}">
                                {{ str_pad($t->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n', strtotime($t->tanggal))) . '/' . date('Y', strtotime($t->tanggal)) }}
                            </a>
                        </td>
                        <td>{{ date('d F Y', strtotime($t->created_at)) }}</td>
                        <td>{{ $t->subjek }}</td>
                        <td>{{ $t->prioritas }}</td>
                        <td>{{ 'Selesai' }}</td>
                        <td class="text-center">
                            @if (is_null($t->rating))
                                <button type="button" class="btn btn-info rating-btn" data-id="{{ $t->id }}" data-subjek="{{ $t->subjek }}">
                                    Rating
                                </button>
                            @else
                            <span class="text-warning">
                                @for ($i = 0; $i < $t->rating; $i++)
                                    <i class="bx bxs-star"></i>
                                @endfor
                            </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        @media (max-width: 576px) {
            #tiket-table thead th:nth-child(3),
            #tiket-table thead th:nth-child(5) {
                display: none;
            }
            #tiket-table td:nth-child(3), 
            #tiket-table td:nth-child(5) {
                display: none;
            }
        }
    </style>

    <!-- Modal Rating -->
    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="#" method="POST" id="ratingForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ratingModalLabel">Beri Rating Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Pilih rating menggunakan ikon bintang -->
                        <div class="mb-3">
                            <label class="form-label">Rating (1-5)</label>
                            <div class="star-rating d-flex justify-content-center">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" hidden>
                                    <label for="rating-{{ $i }}" class="bx bxs-star" data-value="{{ $i }}"></label>
                                @endfor
                            </div>                            
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="rating_comment" class="form-label">Komentar (Opsional)</label>
                            <textarea class="form-control @error('rating_comment') is-invalid @enderror" id="rating_comment" name="rating_comment" rows="3">{{ old('rating_comment') }}</textarea>
                            @error('rating_comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Rating</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .star-rating {
            direction: ltr;
            display: inline-flex;
            flex-direction: row-reverse;
        }

        .star-rating label {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
            order: 0;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f39c12;
        }
    </style>

    <script>
        document.querySelectorAll('.star-rating label').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-value');
                document.querySelector(`#rating-${rating}`).checked = true;
            });
        });
    </script>
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

        $('.rating-btn').on('click', function() {
            var tiketId = $(this).data('id');
            var subjek = $(this).data('subjek');
            var formAction = "{{ url('/rating') }}/" + tiketId;
            $('#ratingForm').attr('action', formAction);
            $('#ratingModalLabel').text('Beri Rating Pengaduan: ' + subjek);
            $('#ratingModal').modal('show');
        });
    });
</script>
@endpush
