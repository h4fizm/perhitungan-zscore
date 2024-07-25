@extends('main')
@section('title', 'Laman Edit Profil')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Profil</p>
                    </div>
                </div>
                {{-- Isi Form Sebelah Kiri --}}
                <div class="card-body">
                    {{-- Alert untuk menampilkan pesan kesalahan --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Alert untuk menampilkan pesan berhasil --}}
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('list-user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_user" class="form-control-label">Nama User</label>
                                    <input id="nama_user" name="name" class="form-control" type="text" placeholder="Masukkan nama Anda" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Email</label>
                                    <input id="email" name="email" class="form-control" type="email" placeholder="Masukkan alamat email Anda" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-control-label">Password</label>
                                    <input id="password" name="password" class="form-control" type="password" placeholder="Masukkan kata sandi Anda">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-control-label">Re-type Password</label>
                                    <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" placeholder="Masukkan kembali kata sandi Anda">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label">Role User</label>
                                    <select id="role" name="role" class="form-control" onchange="togglePuskesmasField()">
                                        <option value="Admin" {{ ($user->role == 'Admin') ? 'selected' : '' }}>Admin</option>
                                        <option value="Guest" {{ ($user->role == 'Guest') ? 'selected' : '' }}>Guest</option>
                                        <option value="Operator" {{ ($user->role == 'Operator') ? 'selected' : '' }}>Operator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="puskesmas-field" style="display:{{ ($user->role == 'Operator') ? 'block' : 'none' }};">
                                <div class="form-group">
                                    <label for="id_location" class="form-control-label">Pilihan Puskesmas</label>
                                    <select id="id_location" name="id_location" class="form-control">
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ ($user->id_location == $location->id) ? 'selected' : '' }}>{{ $location->name_location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Button Kembali --}}
                        <a href="{{ route('list-user') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        {{-- Button Edit --}}
                        <button type="submit" class="btn btn-warning btn-sm float-end">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        {{-- Informasi User Sebelah Kanan --}}
        <div class="col-md-4">
            <div class="card card-profile">
                {{-- Gambar Background --}}
                <img src="{{ asset('style/assets/img/carousel-1.jpg') }}" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;">
                                {{-- Gambar Profil --}}
                                <img src="{{ asset('style/assets/img/user_logo.jpg') }}" class="rounded-circle img-fluid border border-2 border-black">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="text-center mt-4">
                        <h5>
                            {{ $user->name }}<span class="font-weight-light"></span>
                        </h5>
                         <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2">
                                {{ $user->role }} - {{ $user->location->name_location ?? '' }}
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePuskesmasField() {
    var role = document.getElementById('role').value;
    var puskesmasField = document.getElementById('puskesmas-field');
    if (role === 'Operator') {
        puskesmasField.style.display = 'block';
    } else {
        puskesmasField.style.display = 'none';
    }
}
</script>
@endsection
