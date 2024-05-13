@extends('main')
@section('title', 'Laman Manajemen Role User')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6>Daftar Akun User</h6>
                        <a href="{{ route('list-user.create') }}" class="btn btn-primary"> + Tambah User</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="userTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $index + 1 }}</td>
                                    <td class="text-secondary font-weight-bold text-xs">{{ $user->name }}</td>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $user->email }}</td>
                                    <td class="align-middle text-center text-secondary font-weight-bold text-xs">{{ $user->role }}</td>
                                    <td class="align-middle text-center">
                                        <div class="d-inline-flex justify-content-center align-items-center">
                                            <a href="{{ route('list-user.edit', $user->id) }}" class="badge bg-gradient-warning text-decoration-none me-1 btn-style" style="background-color: #ffc107; color: #fff; margin-bottom: 12px;" data-toggle="tooltip" data-original-title="Edit user">Edit</a>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('list-user.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="badge bg-gradient-danger text-decoration-none ms-1 btn-style delete-btn" style="background-color: #dc3545; color: #fff; " data-user-id="{{ $user->id }}">Hapus</button>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteBtns = document.querySelectorAll('.delete-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function () {
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
