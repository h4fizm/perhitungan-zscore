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
                               @foreach ($pengukuran as $index => $data)
                                <tr>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $index + 1 }}</td>
                                    <td class="text-secondary font-weight-bold text-xs">
                                        @if($data->tanggal_pengukuran)
                                            {{ \Carbon\Carbon::parse($data->tanggal_pengukuran)->format('d F Y') }}
                                        @endif
                                    </td>
                                    <td class="text-secondary font-weight-bold text-xs">{{ $data->umur }} Bulan</td>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $data->berat_badan }}</td>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $data->tinggi_badan }}</td>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $data->status_gizi }}</td>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $data->status_tinggi}}</td>
                                    <td class="align-middle text-center">
                                        <div class="d-inline-flex justify-content-center align-items-center">
                                            <a href="{{ route('edit-pengukuran', ['id' => $data->id]) }}" class="badge bg-gradient-warning text-decoration-none me-1 btn-style mb-3" style="background-color: #ffc107; color: #fff;" data-toggle="tooltip" data-original-title="Edit user">Edit</a>
                                            <!-- Form untuk delete dengan method DELETE -->
                                            <form id="delete-form-{{ $index }}" action="{{ route('hapus-pengukuran', ['id' => $data->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Tombol untuk delete dengan sweetalert -->
                                                <button type="button" class="badge bg-gradient-danger text-decoration-none ms-1 btn-style delete-btn" style="background-color: #dc3545; color: #fff; " data-user-id="{{ $index }}">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteBtns = document.querySelectorAll('.delete-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const userId = this.getAttribute('data-user-id');
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Anda akan menghapus pengguna ini.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-' + userId).submit();
                    } else {
                        swal("Penghapusan dibatalkan.");
                    }
                });
            });
        });
    });
</script>
