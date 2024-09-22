@extends('main')
@section('title', 'Edit Data Pengukuran Pasien')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Isi Form Data Pengukuran Pasien</p>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Alert for form validation errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('update-pengukuran', ['id' => $id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_pengukuran" class="form-control-label">Tanggal
                                            Pengukuran</label>
                                        <input type="date" id="tanggal_pengukuran" name="tanggal_pengukuran"
                                            class="form-control" value="{{ $tanggal_pengukuran->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" disabled>
                                            <option value="{{ $pengukuran->jenis_kelamin }}">
                                                {{ $pengukuran->jenis_kelamin }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="umur" class="form-control-label">Umur (Bulan)</label>
                                            <input type="number" id="umur" name="umur" class="form-control"
                                                value="{{ $pengukuran->umur }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="berat_badan" class="form-control-label">Berat Badan</label>
                                        <input id="berat_badan" name="berat_badan" class="form-control" type='number'
                                            step='0.01' placeholder="Masukkan Berat Badan"
                                            value="{{ $pengukuran->berat_badan }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tinggi_badan" class="form-control-label">Tinggi Badan</label>
                                        <input id="tinggi_badan" name="tinggi_badan" class="form-control" type='number'
                                            step='0.01' placeholder="Masukkan Tinggi Badan"
                                            value="{{ $pengukuran->tinggi_badan }}">
                                    </div>
                                </div>
                            </div>
                            <!-- Add a hidden input for the patient's birth date -->
                            <input type="hidden" id="tanggal_lahir" value="{{ $tanggal_lahir->format('Y-m-d') }}">
                            {{-- Button Kembali --}}
                            <a href="{{ route('detail-pengukuran', ['id' => $id]) }}" class="btn btn-secondary btn-sm"
                                id="btnKembali">Kembali</a>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"></script>
        <script>
            // MQTT setup settings
            const brokerUrl = 'wss://broker.emqx.io:8084/mqtt';
            const clientId = 'publish-' + Math.random().toString(16).substr(2, 8);

            const weightTopic = 'sensor/weight';
            const heightTopic = 'sensor/height';

            var dataBeratBadan = null;
            var dataTinggiBadan = null;
            var dataToggle = true; // Default for edit data

            function connect() {
                const client = new Paho.Client(brokerUrl, clientId);

                client.onConnectionLost = onConnectionLost;
                client.onMessageArrived = onMessageArrived;

                const options = {
                    onSuccess: onConnect,
                    onFailure: onFailure,
                    useSSL: true,
                    timeout: 3,
                    reconnect: true
                };

                client.connect(options);

                function onConnect() {
                    console.log('Connected to MQTT broker');
                    client.subscribe(weightTopic, {
                        qos: 0
                    });
                    client.subscribe(heightTopic, {
                        qos: 0
                    });
                }

                function onFailure(err) {
                    console.error('Connection failed: ', err);
                }

                function onConnectionLost(responseObject) {
                    if (responseObject.errorCode !== 0) {
                        console.error('Connection lost: ', responseObject.errorMessage);
                    }
                }

                function onMessageArrived(message) {
                    console.log(
                        `Received Message: ${message.payloadString.toString()} On topic: ${message.destinationName}`
                    );

                    if (dataToggle && parseFloat(message.payloadString) > 0) {
                        if (message.destinationName === weightTopic) {
                            dataBeratBadan = parseFloat(message.payloadString);
                            var beratBadanElement = document.getElementById('berat_badan');
                            beratBadanElement.value = dataBeratBadan.toFixed(2);
                        } else if (message.destinationName === heightTopic) {
                            dataTinggiBadan = parseFloat(message.payloadString);
                            var tinggiBadanElement = document.getElementById('tinggi_badan');
                            tinggiBadanElement.value = dataTinggiBadan.toFixed(2);
                        }
                    }
                }
            }

            connect();

            document.addEventListener('DOMContentLoaded', function() {
                const tanggalPengukuranInput = document.getElementById('tanggal_pengukuran');
                const umurInput = document.getElementById('umur');
                const tanggalLahirInput = document.getElementById('tanggal_lahir');

                function updateUmur() {
                    const tanggalPengukuran = new Date(tanggalPengukuranInput.value);
                    const tanggalLahir = new Date(tanggalLahirInput.value);

                    // Calculate the difference in months
                    let months = (tanggalPengukuran.getFullYear() - tanggalLahir.getFullYear()) * 12;
                    months -= tanggalLahir.getMonth();
                    months += tanggalPengukuran.getMonth();

                    // Adjust for day of the month
                    if (tanggalPengukuran.getDate() < tanggalLahir.getDate()) {
                        months--;
                    }

                    umurInput.value = months;
                }

                // Update umur when the page loads
                updateUmur();

                // Update umur when tanggal_pengukuran changes
                tanggalPengukuranInput.addEventListener('change', updateUmur);
            });
        </script>
    </div>
@endsection
