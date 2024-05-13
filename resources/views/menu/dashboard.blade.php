{{-- MAIN SECTION --}}
@extends('main')
@section('title', 'Laman Dashboard')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header pb-0">
                 <div class="d-flex justify-content-start align-items-center mt-3">
                    <div>
                        <img src="{{ asset ('style/assets/img/logo-ct-dark.png') }}" alt="Logo" style="width: 60px; height: 60px; margin-right:10px">
                    </div>
                    <div>
                        <h4><strong>Politeknik Kesehatan Kemenkes Surabaya</strong></h4>
                        <h6 class="fw-normal " style="font-size: 0.8rem;">Jalan Pucang Jajar Tengah 56 Surabaya, Jawa Timur</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                {{-- bagian bawah --}}
                </div>
            </div>
            </div>
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between mt-2"> <!-- Tambahkan kelas mt-2 di sini -->
                        <h6><strong>Tulisan nanti </strong></h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                       <h6>
                       ...................................
                       </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
