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
                            <img src="{{ asset('style/assets/img/Antromaps.png') }}" alt="Logo" style="width: 60px; height: 60px; margin-right:10px">
                        </div>
                        <div>
                            <h4><strong>Politeknik Kesehatan Kemenkes Surabaya</strong></h4>
                            <h6 class="fw-normal" style="font-size: 0.8rem;">Jalan Pucang Jajar Tengah 56 Surabaya, Jawa Timur</h6>
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
                    <div class="d-flex justify-content-between mt-2">
                        <h6><strong>Kata Pengantar</strong></h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul style="list-style: none; padding: 0;">
                                <li>
                                    <p style="text-align: justify;">
                                        Periode balita, yang mencakup usia 0-5 tahun, dikenal sebagai masa emas karena di sinilah fondasi dasar perkembangan fisik, kognitif, bahasa, sosial, dan emosional anak dibentuk. Sistem pemantauan tumbuh kembang balita sangat penting karena dapat mendeteksi masalah kesehatan dan dan perkembangan pada usia dini, sehingga jika terdeteksi masalah sejak dini dapat dilakukan intervensi tepat waktu. Sistem pemantauan ini mencakup pengukuran rutin tinggi badan dan berat badan yang akan mempengaruhi perkembangan motorik kasar dan halus serta kognitif pada bayi dan balita. Data ini dibandingkan dengan standar pertumbuhan untuk memastikan tumbuh kembang balita sesuai dengan anak seusianya. Selain itu sistem pemantauan ini juga dapat memberikan edukasi berupa informasi kepada orang tua mengenai tumbuh kembang anaknya, kemudian dengan adanya pemetaan daerah, data yang diperoleh dapat digunakan untuk perencanaan program kesehatan dan program intervensi untuk meningkatkan kesehatan dan kesejahteraan anak-anak di suatu daerah.
                                    </p>
                                </li>
                                <li>
                                    <p style="text-align: justify;">
                                        <em>"Antromaps merupakan sistem pemantauan tumbuh kembang balita yang dilengkapi dengan pemetaan daerah untuk memantau potensi penyebaran stunting di daerah kecamatan Gubeng, Surabaya."</em>
                                    </p>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
