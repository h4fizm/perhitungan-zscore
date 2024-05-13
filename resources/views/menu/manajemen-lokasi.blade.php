@extends('main')
@section('title', 'Manajemen Lokasi')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6>Daftar Lokasi</h6>
                        <a href="{{ route('lokasi.create') }}" class="btn btn-primary"> + Tambah Lokasi</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="userTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lokasi</th>
                                    <th class="text-uppercase  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu Pointing</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Pasien</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop through each location and display its data --}}
                                @foreach($locations as $key => $location)
                               <tr>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $key + 1 }}</td>
                                    <td class="text-secondary font-weight-bold text-xs">{{ $location->name_location }}</td>
                                    <td class="text-secondary  font-weight-bold text-xs">{{ $location->created_at->format('d/m/Y') }}</td>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $location->jumlah_pasien }}</td>
                                    <td class="text-center">
                                        @if($location->jumlah_pasien > 50)
                                            <span class="badge bg-gradient-danger"> {{ $location->status }} </span>
                                        @elseif($location->jumlah_pasien >= 10 && $location->jumlah_pasien <= 50)
                                            <span class="badge bg-gradient-warning"> {{ $location->status }} </span>
                                        @else
                                            <span class="badge bg-gradient-success"> {{ $location->status }} </span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-inline-flex">
                                            <a href="{{ route('lokasi.edit', $location->id) }}" class="badge bg-gradient-warning me-1" data-toggle="tooltip" data-original-title="Edit lokasi">Edit</a>
                                            <form action="{{ route('lokasi.destroy', $location->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-gradient-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">Hapus</button>
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

