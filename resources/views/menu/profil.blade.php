{{-- MAIN SECTION --}}
@extends('main')
@section('title', 'Laman Profil')
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
                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_user" class="form-control-label">Nama User</label>
                                    <input id="nama_user" name="name" class="form-control" type="text" placeholder="Masukkan nama Anda" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Email</label>
                                    <input id="email" name="email" class="form-control" type="email" placeholder="Masukkan alamat email Anda" value="{{ auth()->user()->email }}">
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
                                    <select id="role" name="role" class="form-control">
                                        <option value="admin" {{ (auth()->user()->role == 'admin') ? 'selected' : '' }}>Admin</option>
                                        <option value="guest" {{ (auth()->user()->role == 'guest') ? 'selected' : '' }}>Guest</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                <img src="{{ asset('style/assets/img/bg-profile.jpg') }}" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;">
                                {{-- Gambar Profil --}}
                                <img src="{{ asset('style/assets/img/team-2.jpg') }}" class="rounded-circle img-fluid border border-2 border-white">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                <div class="text-center mt-4">
                    <h5>
                        {{ auth()->user()->name }}<span class="font-weight-light"></span>
                    </h5>
                    <div class="h6 font-weight-300">
                        <i class="ni location_pin mr-2">
                            {{ auth()->user()->role }}
                        </i>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
