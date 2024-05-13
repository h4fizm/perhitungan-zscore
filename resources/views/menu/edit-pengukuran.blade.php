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
                    <form action="{{ route('update-pengukuran', ['id' => $pengukuran->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                        @foreach($jenis_kelamin as $jk)
                                        <option value="{{ $jk }}">{{ $jk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur" class="form-control-label">Umur</label>
                                    <select id="umur" name="umur" class="form-control">
                                        @foreach($umurOptions as $umur)
                                        <option value="{{ $umur }}">{{ $umur }} Bulan</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="berat_badan" class="form-control-label">Berat Badan</label>
                                    <input id="berat_badan" name="berat_badan" class="form-control" type="number" placeholder="Masukkan Berat Badan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tinggi_badan" class="form-control-label">Tinggi Badan</label>
                                    <input id="tinggi_badan" name="tinggi_badan" class="form-control" type="number" placeholder="Masukkan Tinggi Badan">
                                </div>
                            </div>
                        </div>
                         {{-- Button Kembali --}}
                        <a href="{{ route('detail-pengukuran', ['id' => $pengukuran->id_pasien]) }}" class="btn btn-secondary btn-sm" id="btnKembali">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
