@extends('main')
@section('title', 'Edit Data Pasien')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12"> <!-- Mengubah col-md-8 menjadi col-md-10 -->
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Data Pasien</p>
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
                    <form action="{{ route('update-pasien', $pasien->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik" class="form-control-label">NIK</label>
                                    <input id="nik" name="nik" class="form-control" type="number" value="{{ $pasien->nik }}" placeholder="Masukkan NIK">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-control-label">Nama</label>
                                    <input id="nama" name="nama" class="form-control" type="text" value="{{ $pasien->nama }}" placeholder="Masukkan nama Anda">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                        @foreach($jenis_kelamin as $jk)
                                        <option value="{{ $jk }}" @if($pasien->jenis_kelamin == $jk) selected @endif>{{ ucfirst($jk) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
                                    <input id="tanggal_lahir" name="tanggal_lahir" class="form-control" type="date" value="{{ $pasien->tanggal_lahir }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_lahir" class="form-control-label">Tempat Lahir</label>
                                    <input id="tempat_lahir" name="tempat_lahir" class="form-control" type="text" value="{{ $pasien->tempat_lahir }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_ortu" class="form-control-label">Nama Orang Tua</label>
                                    <input id="nama_ortu" name="nama_ortu" class="form-control" type="text" value="{{ $pasien->nama_ortu }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_ortu" class="form-control-label">Email Orang Tua</label>
                                    <input id="email_ortu" name="email_ortu" class="form-control" type="email" value="{{ $pasien->email_ortu }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat" class="form-control-label">Alamat</label>
                                    <input id="alamat" name="alamat" class="form-control" type="text" value="{{ $pasien->alamat }}" placeholder="Masukkan alamat">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lembaga" class="form-control-label">Lembaga Faskes yang dipilih</label>
                                    <select id="faskes" name="faskes" class="form-control">
                                        @foreach($faskes as $key => $value)
                                        <option value="{{ $key }}" @if($pasien->id_location == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Button Kembali --}}
                        <a href="{{ route('list-pasien') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
