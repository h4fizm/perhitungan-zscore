@extends('main')
@section('title', 'Tambah User')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Tambah User</p>
                    </div>
                </div>
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
                    <form action="{{ route('list-user.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nama User</label>
                                    <input id="name" name="name" class="form-control" type="text" placeholder="Masukkan nama Anda">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Email</label>
                                    <input id="email" name="email" class="form-control" type="email" placeholder="Masukkan alamat email Anda">
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
                                    <label for="password_confirmation" class="form-control-label">Konfirmasi Password</label>
                                    <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" placeholder="Masukkan kembali kata sandi Anda">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label">Role User</label>
                                    <select id="role" name="role" class="form-control">
                                        <option value="Admin">Admin</option>
                                        <option value="Guest">Guest</option>
                                        <option value="Operator">Operator</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Button Kembali --}}
                        <a href="{{ route('list-user') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
