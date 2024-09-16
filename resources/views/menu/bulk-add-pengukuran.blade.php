@extends('main')
@section('title', 'Bulk Add Pengukuran')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Bulk Add Pengukuran</p>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('bulk-add-pengukuran') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="id">Pasien ID</label>
                            <input type="number" class="form-control" id="id" name="id" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="randomize_all" name="randomize_all">
                            <label class="form-check-label" for="randomize_all">
                                Randomize all values
                            </label>
                        </div>
                        @for ($umur = 0; $umur <= 60; $umur++)
                            <div class="row">
                                <div class="col-md-2">
                                    <strong>Age: {{ $umur }} months</strong>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="berat_badan_{{ $umur }}">Berat Badan</label>
                                        <input type="number" step="0.01" class="form-control" id="berat_badan_{{ $umur }}" name="berat_badan[{{ $umur }}]">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tinggi_badan_{{ $umur }}">Tinggi Badan</label>
                                        <input type="number" step="0.01" class="form-control" id="tinggi_badan_{{ $umur }}" name="tinggi_badan[{{ $umur }}]">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="randomize_{{ $umur }}" name="randomize[{{ $umur }}]">
                                        <label class="form-check-label" for="randomize_{{ $umur }}">
                                            Randomize
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection