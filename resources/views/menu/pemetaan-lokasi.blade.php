{{-- MAIN SECTION --}}
@extends('main')
@section('title', 'Pemetaan Lokasi')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3 mb-4"> <!-- Kolom untuk pencarian -->
            <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari Nama Kelurahan ....">
            </div>
        </div>
        <div class="col-lg-3 mb-4"> <!-- Kolom untuk opsi tanggal -->
            <div class="input-group">
                <span class="input-group-text text-body"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                <input type="date" class="form-control" id="dateInput">
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-lg-12"> <!-- Kolom untuk peta -->
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between mb-2">
                        <h6>Wilayah Pemetaan Lokasi Pasien</h6>
                    </div>
                </div>
                {{-- Letak Posisi dan Ukuran Peta --}}
                <div id="map" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS Javascript -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-7.28392, 112.74567], 14); // set koordinat dan zoom untuk Gubeng, Surabaya

    // Tambahkan layer peta dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Data lokasi dari PHP ke JavaScript
    var locations = [
        @foreach($locations as $location)
        {
            name: "{{ $location->name_location }}",
            latitude: {{ $location->latitude }},
            longitude: {{ $location->longitude }},
            color: "{{ $location->color }}",
            radius: {{ $location->radius }},
            created_at: "{{ $location->created_at }}"
        },
        @endforeach
    ];

    // Menyimpan semua marker awal sebelum pencarian
    var initialMarkers = [];
    locations.forEach(function(location) {
        var marker = L.marker([location.latitude, location.longitude]).addTo(map);
        marker.bindPopup("<div style='font-size: 16px; text-align: center;'>" + location.name + "</div>");
        initialMarkers.push(marker);
    });

    // Fungsi untuk melakukan pencarian berdasarkan nama lokasi
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        var searchValue = e.target.value.toLowerCase();
        
        // Menghapus semua layer sebelumnya
        map.eachLayer(function(layer) {
            if (layer instanceof L.Circle || layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        // Jika pencarian kosong, tampilkan kembali semua marker
        if (searchValue === '') {
            initialMarkers.forEach(function(marker) {
                marker.addTo(map);
            });
            return;
        }

        // Menampilkan hanya lokasi yang sesuai dengan pencarian
        locations.forEach(function(location) {
            if (location.name.toLowerCase().includes(searchValue)) {
                var marker = L.marker([location.latitude, location.longitude]).addTo(map);
                marker.bindPopup("<div style='font-size: 16px; text-align: center;'>" + location.name + "</div>");

                // Menampilkan lingkaran radius jika nama lokasi sesuai dengan pencarian
                var circle = L.circle([location.latitude, location.longitude], {
                    color: location.color,
                    fillColor: location.color,
                    fillOpacity: 0.5,
                    radius: location.radius
                }).addTo(map);
            }
        });
    });

    // Fungsi untuk melakukan pencarian berdasarkan tanggal
    document.getElementById('dateInput').addEventListener('change', function(e) {
        var selectedDate = e.target.value;
        console.log("Tanggal yang dipilih:", selectedDate);
        
        // Menghapus semua layer sebelumnya
        map.eachLayer(function(layer) {
            if (layer instanceof L.Circle || layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        // Menampilkan hanya lokasi yang dibuat pada tanggal yang dipilih
        initialMarkers.forEach(function(marker) {
            var location = locations.find(function(location) {
                return location.latitude === marker.getLatLng().lat && location.longitude === marker.getLatLng().lng;
            });
            if (location && location.created_at.split(' ')[0] === selectedDate) {
                marker.addTo(map);
                var circle = L.circle([location.latitude, location.longitude], {
                    color: location.color,
                    fillColor: location.color,
                    fillOpacity: 0.5,
                    radius: location.radius
                }).addTo(map);
            }
        });
    });
</script>

@endsection
