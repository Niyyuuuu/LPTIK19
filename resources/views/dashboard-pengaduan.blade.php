@extends('layouts.app')

@section('title', 'Dashboard Pengaduan')

@section('content')
<div class="container">
    <h1 class="fw-bold text-center mt-3 mb-3">Dashboard Pengaduan</h1>
    
    <!-- Form Pilihan Tahun -->
    <form method="GET" action="{{ route('dashboard-pengaduan') }}">
        <div class="mb-3 w-75 text-center mx-auto">
            <label for="tahun" class="form-label">Pilih Tahun</label>
            <select id="tahun" name="tahun" class="form-select" onchange="this.form.submit()">
                @foreach (range(2022, date('Y') + 2) as $yearOption)
                    <option value="{{ $yearOption }}" {{ $tahun == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Kartu Statistik Pengaduan -->
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
