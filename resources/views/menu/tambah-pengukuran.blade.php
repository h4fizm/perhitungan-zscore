@extends('main')
@section('title', 'Tambah Data Pengukuran Pasien')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12"> <!-- Mengubah col-md-8 menjadi col-md-10 -->
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Isi Form Data Pengukuran Pasien</p>
                    </div>
                </div>
                <div class="card-body">
                   @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Alert untuk gagal validasi form -->
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('simpan-pengukuran', ['id' => $id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-control-label">Jenis Kelamin</label>
                                        <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="form-control" value="{{ $pasien->jenis_kelamin }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="umur" class="form-control-label">Umur</label>
                                        <input type="text" id="umur_display" class="form-control" value="{{ $umur }} Bulan" readonly>
                                        <input type="hidden" id="umur" name="umur" value="{{ $umur }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="berat_badan" class="form-control-label">Berat Badan</label>
                                        <input id="berat_badan" name="berat_badan" class="form-control" type='number' step='0.01' value='0.00' placeholder="Masukkan Berat Badan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tinggi_badan" class="form-control-label">Tinggi Badan</label>
                                        <input id="tinggi_badan" name="tinggi_badan" class="form-control" type='number' step='0.01' value='0.00' placeholder="Masukkan Tinggi Badan">
                                    </div>
                                </div>
                            </div>
                            {{-- Button Kembali --}}
                            <a href="{{ route('list-pasien')}}" class="btn btn-secondary btn-sm" id="btnKembali">Kembali</a>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Simpan</button>
                            <button id="dataToggle" class="btn btn-warning btn-sm float-end">Matikan Data</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // MQTT setup settings
        const brokerUrl = 'wss://broker.emqx.io:8084/mqtt';
        const clientId = 'publish-' + Math.random().toString(16).substr(2, 8);
        const topic = 'zscore/bbtb';

        // Data settings
        var dataToggle = true; // Default for tambah data

        function toggleData() {
            // Toggle the boolean variable
            dataToggle = !dataToggle;
            
            // Get the button element
            const button = document.getElementById('dataToggle');
            
            // Change the button text based on the boolean variable
            if (dataToggle) {
                button.textContent = 'Matikan Data';
            } else {
                button.textContent = 'Hidupkan Data';
            }
        }

        // Add event listener to the button
        document.getElementById('dataToggle').addEventListener('click', toggleData);

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
                client.subscribe(topic, { qos: 0 }, (err) => {
                    if (err) {
                        console.error('Subscription failed: ', err);
                    } else {
                        console.log(`Subscribed to topic: ${topic}`);
                    }
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
                    `Received Message: ${message.payloadString.toString()} On topic: ${topic}`
                );

                if (dataToggle) {
                    // Get data
                    var data = message.payloadString.toString().split(",");
                    var dataBeratBadan = parseFloat(data[0]);
                    var dataBeratBadan = parseFloat(data[1]);
    
                    // Get input element
                    var beratBadanElement = document.getElementById('berat_badan');
                    var tinggiBadanElement = document.getElementById('tinggi_badan');
    
                    // Change input value
                    beratBadanElement.value = dataBeratBadan.toFixed(2);
                    tinggiBadanElement.value = dataBeratBadan.toFixed(2);
                }
            }
        }

        connect();
    </script>
</div>
@endsection
