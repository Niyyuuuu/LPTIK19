    @extends('layouts.app')

    @section('title', 'Dashboard Pengaduan')

    @section('content')
    <div class="container">
        <h1 class="fw-bold text-center mt-3 mb-3">Dashboard Pengaduan</h1>
        <!-- Notification for 'Proses Selesai' -->
        <!-- Mail Icon Notification -->
        @if ($prosesSelesaiCount > 0)
        <button class="btn btn-warning position-absolute top-0 end-0 m-3" data-bs-toggle="modal" data-bs-target="#prosesSelesaiModal">
            <i class="bx bx-envelope">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $prosesSelesaiCount }}
                </span>
            </i>
        </button>
        @endif
    
        <!-- Modal for Proses Selesai Tickets -->
        <div class="modal fade" id="prosesSelesaiModal" tabindex="-1" aria-labelledby="prosesSelesaiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prosesSelesaiModalLabel">Tiket Proses Selesai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            @foreach ($prosesSelesaiTickets as $ticket)
                            <li>
                                <a onclick="window.location.href='{{ url('/daftar-pengaduan') }}'" class="text-decoration-none">
                                    Ticket: No. {{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }} | Subjek: {{ $ticket->subjek }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Pilihan Tahun -->
        <form method="GET" action="{{ route('dashboard-pengaduan') }}">
            <div class="mb-3 w-75 text-center mx-auto">
                <label for="tahun" class="form-label">Pilih Tahun</label>
                <select id="tahun" name="tahun" class="form-select"> 
                    @foreach (range(2022, date('Y') + 2) as $yearOption)
                        <option value="{{ $yearOption }}" {{ $tahun == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row mb-3 justify-content-center align-items-end">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control"
                           value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control"
                           value="{{ $endDate }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
        

        

        <!-- Kartu Statistik Pengaduan -->
        <a href="{{ url('/daftar-pengaduan') }}">
            <div class="row g-4 mb-5 justify-content-center">
                @foreach ($cardData as $title => $count)
                <div class="col-md-6 col-sm-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold mt-2 mb-2">{{ $title }}</h5>
                            <p class="fs-2 text-primary">{{ $count }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </a>

        <!-- Chart Pengaduan Per Bulan -->
        <div class="mt-4">
            <div id="pengaduanChart" style="width: 100%; height: 260px;"></div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('pengaduanChart', {
                chart: {
                    type: 'column',
                    style: {
                        fontFamily: 'Poppins, sans-serif'
                    }
                },
                title: {
                    text: 'Jumlah Pengaduan Tahun {{ $tahun }}',
                    style: {
                        fontFamily: 'Poppins, sans-serif'
                    }
                },
                xAxis: {
                    categories: {!! json_encode($monthNames) !!},
                    title: {
                        style: {
                            fontFamily: 'Poppins, sans-serif'
                        }
                    },
                    labels: {
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Pengaduan',
                        align: 'high',
                        style: {
                            fontFamily: 'Poppins, sans-serif'
                        }
                    },
                    labels: {
                        style: {
                            fontFamily: 'Poppins, sans-serif'
                        }
                    }
                },
                tooltip: {
                    valueSuffix: ' pengaduan',
                    style: {
                        fontFamily: 'Poppins, sans-serif'
                    }
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: false,
                            style: {
                                fontFamily: 'Poppins, sans-serif'
                            }
                        },
                        enableMouseTracking: true
                    }
                },
                series: @json($dataPerStatus),
                credits: {
                    enabled: false
                }
            });
        });

        const hamBurger = document.querySelector(".toggle-btn");
        if (hamBurger) {
            hamBurger.addEventListener("click", function() {
                document.querySelector("#sidebar").classList.toggle("expand");
            });
        }
    </script>
    @endpush
