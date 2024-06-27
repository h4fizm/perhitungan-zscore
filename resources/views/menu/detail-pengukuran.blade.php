@extends('main')
@section('title', 'Informasi Pasien')
@section('content')
    <div class="container-fluid py-4">
        {{-- Form Detail Pasien --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nik" class="form-control-label">NIK</label>
                                        <!-- Tambahkan atribut readonly -->
                                        <input id="nik" name="nik" class="form-control" type="text"
                                            value="{{ $pasien->nik }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama" class="form-control-label">Nama</label>
                                        <input id="nama" name="nama" class="form-control" type="text"
                                            value="{{ $pasien->nama }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                        <input id="jenis_kelamin" name="jenis_kelamin" class="form-control" type="text"
                                            value="{{ $pasien->jenis_kelamin }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
                                        <input id="tanggal_lahir" name="tanggal_lahir" class="form-control" type="date"
                                            value="{{ $pasien->tanggal_lahir }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat" class="form-control-label">Alamat</label>
                                        <input id="alamat" name="alamat" class="form-control" type="text"
                                            value="{{ $pasien->alamat }}" readonly>
                                    </div>
                                </div>
                                <!-- Lembaga Faskes -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faskes" class="form-control-label">Lembaga Faskes yang dipilih</label>
                                        <input id="faskes" name="faskes" class="form-control" type="text"
                                            value="{{ $faskes[$pasien->id_location] }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('list-pasien') }}" class="btn btn-secondary btn-sm">Kembali</a>
                            <button type="button" class="btn btn-primary btn-sm float-end"
                                onclick="window.location='{{ route('tambah-pengukuran', ['id' => $id]) }}'">+ Tambah Data
                                Pengukuran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Berat Badan Menurut Umur</h6>
                        <p class="text-sm mb-0">
                        <div style="width: 100%; margin: auto;">
                            <canvas id="myChart"></canvas>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
            {{-- <p>{{ $ZScoreWeight }}</p>
            <p>{{ $ZScoreHeight }}</p>
            <p>Z Score untuk Berat Badan Menurut Tinggi Badan</p>
            <p>{{ $ZScoreWH }}</p>
            <p>ini ada</p> --}}

            {{-- Grafik kedua --}}
            <div class="col-lg-12 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Tinggi Badan Menurut Umur</h6>
                        <p class="text-sm mb-0">
                        <div style="width: 100%; margin: auto;">
                            <canvas id="heightToAgeChart"></canvas>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
            {{-- Grafik ketiga --}}
            <div class="col-lg-12 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Berat Badan Menurut Tinggi Badan</h6>
                        <p class="text-sm mb-0">
                        <div style="width: 100%; margin: auto;">
                            <canvas id="weightToHeightChart"></canvas>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabel Banyak Data Pengukuran Pasien --}}
        @php
            use Carbon\Carbon;
        @endphp

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title">Banyak Data Pengukuran Pasien</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="userTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            No</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Pengukuran</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Umur</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Berat Badan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tinggi Badan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status Gizi Pasien</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status Tinggi Pasien</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($measurements as $index => $measurement)
                                        <tr>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $index + 1 }}</td>
                                            <td class="text-secondary font-weight-bold text-xs">
                                                {{ Carbon::parse($measurement->tanggal_pengukuran)->translatedFormat('d F Y') }}
                                            </td>
                                            <td class="text-secondary font-weight-bold text-xs">{{ $measurement->umur }}
                                                Bulan</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $measurement->berat_badan }}</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $measurement->tinggi_badan }}</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $measurement->status_gizi }}</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $measurement->status_tinggi }}</td>
                                            <td class="align-middle text-center">
                                                <div class="d-inline-flex flex-column align-items-center">
                                                    @if ($index > 0 || ($index == 0 && $measurement->berat_badan != 0 && $measurement->tinggi_badan != 0))
                                                        <a href="{{ route('edit-pengukuran', ['id' => $measurement->id]) }}"
                                                            class="btn btn-warning btn-sm mb-2"
                                                            style="width: 80px; padding: 5px;">EDIT</a>
                                                        <form id="delete-form-{{ $measurement->id }}"
                                                            action="{{ route('delete-pengukuran', ['id' => $measurement->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                style="width: 80px; padding: 5px;"
                                                                onclick="confirmDelete({{ $measurement->id }})">HAPUS</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($measurements->isEmpty())
                                        <tr>
                                            <td colspan="8"
                                                class="text-center text-secondary font-weight-bold text-xs">Tidak ada data
                                                pengukuran</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

<!-- SweetAlert Script -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function confirmDelete(id) {
        swal({
                title: "Apakah Anda yakin?",
                text: "Anda akan menghapus pengukuran ini.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('delete-form-' + id).submit();
                } else {
                    swal("Penghapusan dibatalkan.");
                }
            });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
    const ZScoreWH = @json($ZScoreWH);
    const ZScoreHeight = @json($ZScoreHeight);
    const ZScoreWeight = @json($ZScoreWeight);
    const Weight = @json($Weight);
    const Height = @json($height);
    const Age = @json($pasien->umur);

    // Weight to Age Chart
    const weightToAgeLabels = @json($bblabels);
    const n3sdWeightData = @json($bbn3sdData);
    const p3sdWeightData = @json($bbp3sdData);
    const n2sdWeightData = @json($bbn2sdData);
    const p2sdWeightData = @json($bbp2sdData);
    const n1sdWeightData = @json($bbn1sdData);
    const p1sdWeightData = @json($bbp1sdData);
    const weightBaseColor = "{{ $pasien->jenis_kelamin == 'laki-laki' ? 'red' : 'red' }}";
    const weightOverlayColor = 'orange';
    const midColor = 'green';

    const weightToAgeData = {
        labels: weightToAgeLabels,
        datasets: [{
                label: 'N3SD',
                data: n3sdWeightData,
                fill: '+1',
                backgroundColor: weightBaseColor,
                borderColor: weightBaseColor,
                borderWidth: 1,
                order: 3
            },
            {
                label: 'P3SD',
                data: p3sdWeightData,
                fill: '-1',
                backgroundColor: weightBaseColor,
                borderColor: weightBaseColor,
                borderWidth: 1,
                order: 3
            },
            {
                label: 'N2SD',
                data: n2sdWeightData,
                fill: '+1',
                backgroundColor: weightOverlayColor,
                borderColor: weightOverlayColor,
                borderWidth: 1,
                order: 2
            },
            {
                label: 'P2SD',
                data: p2sdWeightData,
                fill: '-1',
                backgroundColor: weightOverlayColor,
                borderColor: weightOverlayColor,
                borderWidth: 1,
                order: 2
            },
            {
                label: 'N1SD',
                data: n1sdWeightData,
                fill: '+1',
                backgroundColor: midColor,
                borderColor: midColor,
                borderWidth: 1,
                order: 1
            },
            {
                label: 'P1SD',
                data: p1sdWeightData,
                fill: '-1',
                backgroundColor: midColor,
                borderColor: midColor,
                borderWidth: 1,
                order: 1
            },
            {
                label: 'Berat Badan Pasien',
                data: [{ x: Age, y: Weight }],
                backgroundColor: 'blue',
                borderColor: 'blue',
                borderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                type: 'scatter',
                showLine: false
            }
        ]
    };

    const weightToAgeConfig = {
        type: 'line',
        data: weightToAgeData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    // text: 'Weight to Age Chart'
                },
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Umur (bulan)'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Berat Badan (kg)'
                    }
                }
            }
        },
    };

    // Height to Age Chart
    const heightToAgeLabels = @json($heightToAgeLabels);
    const n3sdHeightData = @json($n3sdHeightData);
    const p3sdHeightData = @json($p3sdHeightData);
    const n2sdHeightData = @json($n2sdHeightData);
    const p2sdHeightData = @json($p2sdHeightData);
    const n1sdHeightData = @json($n1sdHeightData);
    const p1sdHeightData = @json($p1sdHeightData);
    const heightBaseColor = "{{ $pasien->jenis_kelamin == 'laki-laki' ? 'red' : 'red' }}";
    const heightOverlayColor = 'orange';

    const heightToAgeData = {
        labels: heightToAgeLabels,
        datasets: [{
                label: 'N3SD',
                data: n3sdHeightData,
                fill: '+1',
                backgroundColor: heightBaseColor,
                borderColor: heightBaseColor,
                borderWidth: 1,
                order: 3
            },
            {
                label: 'P3SD',
                data: p3sdHeightData,
                fill: '-1',
                backgroundColor: heightBaseColor,
                borderColor: heightBaseColor,
                borderWidth: 1,
                order: 3
            },
            {
                label: 'N2SD',
                data: n2sdHeightData,
                fill: '+1',
                backgroundColor: heightOverlayColor,
                borderColor: heightOverlayColor,
                borderWidth: 1,
                order: 2
            },
            {
                label: 'P2SD',
                data: p2sdHeightData,
                fill: '-1',
                backgroundColor: heightOverlayColor,
                borderColor: heightOverlayColor,
                borderWidth: 1,
                order: 2
            },
            {
                label: 'N1SD',
                data: n1sdHeightData,
                fill: '+1',
                backgroundColor: midColor,
                borderColor: midColor,
                borderWidth: 1,
                order: 1
            },
            {
                label: 'P1SD',
                data: p1sdHeightData,
                fill: '-1',
                backgroundColor: midColor,
                borderColor: midColor,
                borderWidth: 1,
                order: 1
            },
            {
                label: 'Tinggi Badan Pasien',
                data: [{ x: Age, y: Height }],
                backgroundColor: 'blue',
                borderColor: 'blue',
                borderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                type: 'scatter',
                showLine: false
            }
        ]
    };

    const heightToAgeConfig = {
        type: 'line',
        data: heightToAgeData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    // text: 'Height to Age Chart'
                },
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Umur (bulan)'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tinggi Badan (cm)'
                    }
                }
            }
        },
    };

    // Weight To Height Chart
    const weightToHeightLabels = @json($tbValues); // Ensure TB values are treated as strings
    const n3sdWHData = @json($n3sdWeightData);
    const p3sdWHData = @json($p3sdWeightData);
    const n2sdWHData = @json($n2sdWeightData);
    const p2sdWHData = @json($p2sdWeightData);
    const n1sdWHData = @json($n1sdWeightData);
    const p1sdWHData = @json($p1sdWeightData);
    const WHBaseColor = "{{ $pasien->jenis_kelamin == 'laki-laki' ? 'red' : 'red' }}";
    const WHOverlayColor = 'orange';

    const weightToHeightData = {
        labels: weightToHeightLabels,
        datasets: [{
                label: 'N3SD',
                data: n3sdWHData,
                fill: '+1',
                backgroundColor: WHBaseColor,
                borderColor: WHBaseColor,
                borderWidth: 1,
                order: 3
            },
            {
                label: 'P3SD',
                data: p3sdWHData,
                fill: '-1',
                backgroundColor: WHBaseColor,
                borderColor: WHBaseColor,
                borderWidth: 1,
                order: 3
            },
            {
                label: 'N2SD',
                data: n2sdWHData,
                fill: '+1',
                backgroundColor: WHOverlayColor,
                borderColor: WHOverlayColor,
                borderWidth: 1,
                order: 2
            },
            {
                label: 'P2SD',
                data: p2sdWHData,
                fill: '-1',
                backgroundColor: WHOverlayColor,
                borderColor: WHOverlayColor,
                borderWidth: 1,
                order: 2
            },
            {
                label: 'N1SD',
                data: n1sdWHData,
                fill: '+1',
                backgroundColor: midColor,
                borderColor: midColor,
                borderWidth: 1,
                order: 1
            },
            {
                label: 'P1SD',
                data: p1sdWHData,
                fill: '-1',
                backgroundColor: midColor,
                borderColor: midColor,
                borderWidth: 1,
                order: 1
            },
            {
                label: 'Berat Badan Pasien',
                data: [{ x: Height, y: Weight }],
                backgroundColor: 'blue',
                borderColor: 'blue',
                borderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                type: 'scatter',
                showLine: false
            }
        ]
    };

    const weightToHeightConfig = {
        type: 'line',
        data: weightToHeightData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    // text: 'Berat Badan terhadap Tinggi Badan Chart'
                },
            },
            scales: {
                x: {
                    type: 'linear',
                    display: true,
                    title: {
                        display: true,
                        text: 'Tinggi Badan (cm)' // Label for the x-axis
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Berat Badan (kg)'
                    }
                }
            }
        },
    };


    window.onload = function() {
        const weightCtx = document.getElementById('myChart').getContext('2d');
        new Chart(weightCtx, weightToAgeConfig);

        const heightCtx = document.getElementById('heightToAgeChart').getContext('2d');
        new Chart(heightCtx, heightToAgeConfig);

        const wHeightCtx = document.getElementById('weightToHeightChart').getContext('2d');
        new Chart(wHeightCtx, weightToHeightConfig);
    };
</script>
