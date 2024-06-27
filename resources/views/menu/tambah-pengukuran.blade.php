@extends('main')
@section('title', 'Tambah Data Pengukuran Pasien')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12"> <!-- Mengubah col-md-8 menjadi col-md-10 -->
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Isi Form Data Pengukuran Pasien</p>
                    </div>
                </div>
                <div class="card-body">
                   @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Alert untuk gagal validasi form -->
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('simpan-pengukuran', ['id' => $id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                        <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="form-control" value="{{ $pasien->jenis_kelamin }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="umur" class="form-control-label">Umur</label>
                                        <input type="text" id="umur_display" class="form-control" value="{{ $umur }} Bulan" readonly>
                                        <input type="hidden" id="umur" name="umur" value="{{ $umur }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="berat_badan" class="form-control-label">Berat Badan</label>
                                        <input id="berat_badan" name="berat_badan" class="form-control" type='number' step='0.01' value='0.00' placeholder="Masukkan Berat Badan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tinggi_badan" class="form-control-label">Tinggi Badan</label>
                                        <input id="tinggi_badan" name="tinggi_badan" class="form-control" type='number' step='0.01' value='0.00' placeholder="Masukkan Tinggi Badan">
                                    </div>
                                </div>
                            </div>
                            {{-- Button Kembali --}}
                            <a href="{{ route('list-pasien')}}" class="btn btn-secondary btn-sm" id="btnKembali">Kembali</a>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
