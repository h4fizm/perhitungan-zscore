@extends('main')
@section('title', 'Edit Lokasi')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Lokasi</p>
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
                    <form action="{{ route('lokasi.update', $location->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name_location">Nama Lokasi</label>
                                <input type="text" class="form-control" id="name_location" name="name_location" value="{{ $location->name_location }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $location->latitude }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $location->longitude }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="radius">Radius</label>
                                <input type="text" class="form-control" id="radius" name="radius" value="{{ $location->radius }}" required>
                            </div>
                        </div>
                        {{-- Button Kembali --}}
                        <a href="{{ route('manajemen-lokasi') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <p class="mb-0">Pointing Lokasi pada Peta</p>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS Javascript -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

<script>
    var map = L.map('map').setView([-7.28392, 112.74567], 14); // set koordinat dan zoom awal

    // Tambahkan layer peta dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Inisialisasi Leaflet Draw
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    var drawControl = new L.Control.Draw({
        draw: {
            polygon: false,
            polyline: false,
            rectangle: false,
            circle: {
                shapeOptions: {
                    color: '#f357a1',
                    weight: 4
                },
                showRadius: true,
                metric: true,
                feet: false
            },
            marker: true
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    map.addControl(drawControl);

    // Event listener untuk menangani ketika sebuah objek digambar di peta
    map.on('draw:created', function (e) {
        var type = e.layerType,
            layer = e.layer;

        if (type === 'marker') {
            var latLng = layer.getLatLng();
            document.getElementById('latitude').value = latLng.lat;
            document.getElementById('longitude').value = latLng.lng;
        }

        if (type === 'circle') {
            var radius = layer.getRadius();
            document.getElementById('radius').value = radius.toFixed(2); // Set radius value in the form
        }

        drawnItems.addLayer(layer);
    });
</script>

@endsection
