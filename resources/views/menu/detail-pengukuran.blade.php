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
                                <input id="nik" name="nik" class="form-control" type="text" value="{{ $pasien->nik }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-control-label">Nama</label>
                                <input id="nama" name="nama" class="form-control" type="text" value="{{ $pasien->nama }}" readonly>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                <input id="jenis_kelamin" name="jenis_kelamin" class="form-control" type="text" value="{{ $pasien->jenis_kelamin }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
                                <input id="tanggal_lahir" name="tanggal_lahir" class="form-control" type="date" value="{{ $pasien->tanggal_lahir }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat" class="form-control-label">Alamat</label>
                                <input id="alamat" name="alamat" class="form-control" type="text" value="{{ $pasien->alamat }}" readonly>
                            </div>
                        </div>
                        <!-- Lembaga Faskes -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="faskes" class="form-control-label">Lembaga Faskes yang dipilih</label>
                                <input id="faskes" name="faskes" class="form-control" type="text" value="{{ $faskes[$pasien->id_location] }}" readonly>
                            </div>
                        </div>
                    </div>
                        {{-- Button Kembali --}}
                        <a href="{{ route('list-pasien') }}" class="btn btn-secondary btn-sm">Kembali</a>
                       <button type="button" class="btn btn-primary btn-sm float-end" onclick="window.location='{{ route('tambah-pengukuran', ['id' => $id]) }}'">+ Tambah Data Pengukuran</button>
                     </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Grafik --}}
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Grafik Berat Badan Menurut Umur</h6>
                    <p class="text-sm mb-0">
                       
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- Grafik kedua --}}
        <div class="col-lg-12 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Grafik Tinggi Badan Menurut Umur</h6>
                    <p class="text-sm mb-0">

                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- Grafik ketiga --}}
        <div class="col-lg-12 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Grafik Berat Badan Menurut Tinggi Badan</h6>
                    <p class="text-sm mb-0">
                        
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pengukuran</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Umur</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Berat Badan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tinggi Badan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Gizi Pasien</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Tinggi Pasien</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach($measurements as $index => $measurement)
                                    <tr>
                                        <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $index + 1 }}</td>
                                        <td class="text-secondary font-weight-bold text-xs">{{ Carbon::parse($measurement->tanggal_pengukuran)->translatedFormat('d F Y') }}</td>
                                        <td class="text-secondary font-weight-bold text-xs">{{ $measurement->umur }} Bulan</td>
                                        <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $measurement->berat_badan }}</td>
                                        <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $measurement->tinggi_badan }}</td>
                                        <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $measurement->status_gizi }}</td>
                                        <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $measurement->status_tinggi }}</td>
                                        <td class="align-middle text-center">
                                            <div class="d-inline-flex flex-column align-items-center">
                                                @if($index > 0 || ($index == 0 && $measurement->berat_badan != 0 && $measurement->tinggi_badan != 0))
                                                <a href="{{ route('edit-pengukuran', ['id' => $measurement->id]) }}" class="btn btn-warning btn-sm mb-2" style="width: 80px; padding: 5px;">Edit</a>
                                                <form id="delete-form-{{ $measurement->id }}" action="{{ route('delete-pengukuran', ['id' => $measurement->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" style="width: 80px; padding: 5px;" onclick="confirmDelete({{ $measurement->id }})">Hapus</button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($measurements->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center text-secondary font-weight-bold text-xs">Tidak ada data pengukuran</td>
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