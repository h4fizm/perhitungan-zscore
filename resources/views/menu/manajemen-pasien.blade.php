@extends('main')
@section('title', 'Laman Daftar Pasien')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-3 mb-4"> <!-- Kolom untuk pencarian -->
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari nama pasien/faskes/....">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h6>Daftar Pasien</h6>
                            <a href="{{ route('tambah-pasien') }}" class="btn btn-primary"> + Tambah Pasien</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="dataTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-5">
                                            NIK
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Jenis Kelamin
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Umur
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Lokasi Faskes
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status Pasien
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                               <tbody>
                                    @if ($pasien->isNotEmpty())
                                        @foreach ($pasien as $data)
                                            <tr>
                                                <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                    {{ $data->nik }}
                                                </td>
                                                <td class="text-secondary font-weight-bold text-xs">
                                                    {{ $data->nama }}
                                                </td>
                                                <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                    @if ($data->jenis_kelamin == 'laki-laki')
                                                        <span class="badge bg-primary">Laki-laki</span>
                                                    @else
                                                        <span class="badge bg-danger">Perempuan</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                    {{ $data->umur }} Bulan
                                                </td>
                                                <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                    {{ $data->location->name_location }}
                                                </td>
                                                <td class="align-middle text-center text-secondary font-weight-bold text-xs">
                                                    XXXXXX
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-inline-flex flex-column align-items-center">
                                                        <a href="{{ route('detail-pengukuran', $data->id) }}"
                                                        class="btn btn-info btn-sm mb-2"
                                                        style="width: 100px; padding: 5px;" data-toggle="tooltip"
                                                        data-original-title="Info user">INFO</a>
                                                        <a href="{{ route('edit-pasien', $data->id) }}"
                                                        class="btn btn-warning btn-sm mb-2"
                                                        style="width: 100px; padding: 5px;" data-toggle="tooltip"
                                                        data-original-title="Edit user">EDIT</a>
                                                        <form id="delete-form-{{ $data->id }}"
                                                            action="{{ route('list-pasien.destroy', $data->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                                    style="width: 100px; padding: 5px;"
                                                                    data-user-id="{{ $data->id }}">HAPUS</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No data available</td>
                                        </tr>
                                    @endif
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
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtns = document.querySelectorAll('.delete-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const dataTable = document.getElementById('dataTable');

        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = dataTable.getElementsByTagName('tr');

            // Loop melalui setiap baris data pada tabel
            for (let i = 0; i < rows.length; i++) {
                const rowData = rows[i].getElementsByTagName('td');
                let found = false;

                // Loop melalui setiap sel data pada baris
                for (let j = 0; j < rowData.length; j++) {
                    const cellData = rowData[j].textContent.toLowerCase();
                    // Periksa apakah nilai sel data cocok dengan nilai pencarian
                    if (cellData.indexOf(searchValue) > -1) {
                        found = true;
                        break;
                    }
                }

                // Tampilkan atau sembunyikan baris berdasarkan hasil pencarian
                if (found) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script>
