{{-- MAIN SECTION --}}
@extends('main')
@section('title', 'Grafik Banyak Pasien Tiap Kelurahan')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 text-center">
                    {{-- Periode --}}
                    <h5>Periode Tahun <strong id="periode"></strong></h5> 
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-10">
                            {{-- Grafik --}}
                            <canvas id="kelurahanChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Calculate the current and next year for the period
    var currentYear = new Date().getFullYear();
    var nextYear = currentYear + 1;
    document.getElementById('periode').innerText = currentYear + '-' + nextYear;

    var ctx = document.getElementById('kelurahanChart').getContext('2d');

    var kelurahanNames = @json($kelurahanNames);
    var kelurahanIds = @json($kelurahanIds); // Pastikan kelurahanIds diambil dari controller
    var obesitasPercent = @json($obesitasData);
    var stuntingPercent = @json($stuntingData);
    var normalPercent = @json($normalData);

    var kelurahanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: kelurahanNames, // Tampilkan nama kelurahan saja sebagai label
            datasets: [
                {
                    label: 'Obesitas',
                    data: obesitasPercent,
                    backgroundColor: 'rgba(153, 0, 0, 0.8)', // Dark Red
                    borderColor: 'rgba(153, 0, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Stunting',
                    data: stuntingPercent,
                    backgroundColor: 'rgba(204, 153, 0, 0.8)', // Dark Yellow
                    borderColor: 'rgba(204, 153, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Normal',
                    data: normalPercent,
                    backgroundColor: 'rgba(0, 102, 0, 0.8)', // Dark Green
                    borderColor: 'rgba(0, 102, 0, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            onClick: function(e) {
                var activePoints = kelurahanChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
                if (activePoints.length > 0) {
                    var index = activePoints[0].index;
                    var locationId = kelurahanIds[index];
                    var url = `{{ url('/list-pasien/${locationId}') }}`;
                    window.location.href = url; // Redirect to the corresponding URL
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Persentase Total Pasien (%)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + Math.round(tooltipItem.raw) + '%';
                        }
                    }
                }
            }
        }
    });
</script>

@endsection
