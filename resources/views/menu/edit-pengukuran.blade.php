@extends('main')
@section('title', 'Edit Data Pengukuran Pasien')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
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

                    @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Alert for form validation errors -->
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('update-pengukuran', ['id' => $id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" disabled>
                                        <option value="{{ $pengukuran->jenis_kelamin }}">{{ $pengukuran->jenis_kelamin }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur" class="form-control-label">Umur</label>
                                    <select id="umur" name="umur" class="form-control" disabled>
                                        <option value="{{ $pengukuran->umur }}">{{ $pengukuran->umur }} Bulan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="berat_badan" class="form-control-label">Berat Badan</label>
                                    <input id="berat_badan" name="berat_badan" class="form-control" type='number' step='0.01' placeholder="Masukkan Berat Badan" value="{{ $pengukuran->berat_badan }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tinggi_badan" class="form-control-label">Tinggi Badan</label>
                                    <input id="tinggi_badan" name="tinggi_badan" class="form-control" type='number' step='0.01' placeholder="Masukkan Tinggi Badan" value="{{ $pengukuran->tinggi_badan }}">
                                </div>
                            </div>
                        </div>
                         {{-- Button Kembali --}}
                        <a href="{{ route('detail-pengukuran', ['id' => $id]) }}" class="btn btn-secondary btn-sm" id="btnKembali">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
