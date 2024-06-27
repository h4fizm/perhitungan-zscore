@extends('main')
@section('title', 'Daftar Informasi Kelurahan')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h6>Tabel Informasi Pasien Berdasarkan Lokasi Kelurahan </h6>
                        </div>
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
                                            Lokasi</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Jumlah Pasien</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Normal</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Stunting</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Obesitas</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Loop through each location and display its data --}}
                                    @foreach ($locations as $key => $location)
                                        <tr>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $key + 1 }}</td>
                                            <td class="text-secondary font-weight-bold text-xs">
                                                {{ $location->name_location }}</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $location->jumlah_pasien }}</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $location->jumlah_normal }}</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $location->jumlah_stunting }}</td>
                                            <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                {{ $location->jumlah_obesitas }}</td>
                                            <td class="text-center">
                                                @if ($location->value == 3)
                                                    <span class="badge bg-gradient-success">RENDAH</span>
                                                @elseif ($location->value == 2)
                                                    <span class="badge bg-gradient-warning">MENENGAH</span>
                                                @elseif ($location->value == 1)
                                                    <span class="badge bg-gradient-danger">TINGGI</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center">
                                                <div class="d-inline-flex">
                                                    <a href="{{ route('list-pasien-lokasi', ['id' => $location->id]) }}" class="badge bg-gradient-primary me-1"
                                                        data-toggle="tooltip" data-original-title="Info Pasien">Info
                                                        Pasien</a>
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
