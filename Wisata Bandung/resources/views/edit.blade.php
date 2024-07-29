@extends('layouts.user_type.auth')

@section('content_header')
<!-- Menambahkan stylesheet Leaflet CSS -->
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" /> -->
<!-- Menambahkan script Leaflet JS -->
<!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script> -->
<!-- Menambahkan script Turf.js -->
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@6.5.0/turf.min.js"></script>

@stop <!-- Ini adalah direktif Blade yang menandakan akhir dari suatu bagian (section) dalam template -->

@section('content')


<div>
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/wayang.jpg'); background-position-y: 50%;"></div>

    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Edit Data Wisata</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('tours.update',$tour->id) }}" method="POST" role="form text-left">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="LabelNama" class="form-label">Nama Wisata</label>
                            <div>
                                <input type="text" class="form-control" id="InputNama" name="namatour" placeholder="Nama Wisata" required value="{{ $tour->namatour }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelAlamat" class="form-label">Alamat Wisata</label>
                            <div>
                                <input type="text" class="form-control" id="InputAlamat" name="alamat" placeholder="Alamat Wisata" required value="{{ $tour->alamat }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelJamOperasional" class="form-label">Jam Operasional</label>
                            <div>
                                <input type="text" class="form-control" id="InputJamOperasional" name="jamoperasional" placeholder="Jam Operasional" required value="{{ $tour->jamoperasional }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelBiayaMasuk" class="form-label">Biaya Masuk</label>
                            <div>
                                <input type="text" class="form-control" id="InputBiayaMasuk" name="biayamasuk" placeholder="Rp." required value="{{ $tour->biayamasuk }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelLatitude" class="form-label">Latitude</label>
                            <div>
                                <input type="text" class="form-control" id="InputLatitude" name="latitude" placeholder="Latitude" required value="{{ $tour->latitude }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelLongitude" class="form-label">Longitude</label>
                            <div>
                                <input type="text" class="form-control" id="InputLongitude" name="longitude" placeholder="Longitude" required value="{{ $tour->longitude }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelKontak" class="form-label">Kontak</label>
                            <div>
                                <input type="text" class="form-control" id="InputKontak" name="kontak" placeholder="08xxxx" required value="{{ $tour->kontak }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="about">Deskripsi</label>
                            <div>
                                <input type="text" class="form-control" id="InputDeskripsi" name="deskripsi" placeholder="say something about tourism in Bandung" required value="{{ $tour->deskripsi }}">

                                <!-- <textarea class="form-control" id="InputDeskripsi" rows="3" placeholder="say something about tourism in Bandung" name="deskripsi" required value="{{ $tour->deskripsi }}"></textarea> -->
                            </div>
                        </div>

                        <!-- Bagian peta (Map) dengan tinggi 400px -->
                        <div style="height: 400px;" id="map"></div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('tours.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop <!-- Menandakan akhir dari section 'content', konten utama halaman akan ditempatkan di antara direktif @section('content') dan @stop -->

@push('dashboard') <!-- Menambahkan konten ke dalam sebuah stack bernama 'js' -->
<script>
    // Mengambil nilai longitude dan latitude dari elemen dengan ID "InputLongitude" dan "InputLatitude"
    var longitude = document.getElementById("InputLongitude").value;
    var latitude = document.getElementById("InputLatitude").value;

    // Membuat objek peta Leaflet dengan ID "map", mengatur tampilan peta ke koordinat longitude dan latitude, serta tingkat zoom 17
    var map = L.map('map').setView([latitude, longitude], 17);

    // Menambahkan marker ke peta pada koordinat longitude dan latitude yang telah diambil
    var marker = L.marker([latitude, longitude]).addTo(map);

    // Menambahkan layer peta menggunakan Google Maps Tiles API dengan subdomains mt0, mt1, mt2, dan mt3
    // L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
    //     maxZoom: 19,
    //     subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    // }).addTo(map);

    // var map = L.map('map').setView([-6.873584513844985, 107.57570825178068], 19);

    // var map = L.map('map').setView([-6.8931149, 107.6090784], 15);
    L.tileLayer('https://{s}.google.com/vt?/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 19, // Minumun tingkat zoom
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Mendefinisikan fungsi event click pada peta
    function onMapClick(e) {
        // Menampilkan informasi koordinat saat klik pada peta
        document.getElementById('InputLongitude').value = e.latlng.lng;
        document.getElementById('InputLatitude').value = e.latlng.lat;

        // Menghapus marker yang ada jika sudah ada
        if (marker) {
            map.removeLayer(marker);
        }

        // Menambahkan marker baru pada lokasi klik dan menampilkan popup dengan koordinat
        marker = L.marker(e.latlng).addTo(map)
            .bindPopup("Koordinat: " + e.latlng.toString())
            .openPopup();
    }

    // Menambahkan event listener untuk mendeteksi klik pada peta dan menjalankan fungsi onMapClick
    map.on('click', onMapClick);
</script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil nilai longitude dan latitude dari elemen dengan ID "InputLongitude" dan "InputLatitude"
        var longitude = document.getElementById("InputLongitude").value;
        var latitude = document.getElementById("InputLatitude").value;

        // Log the longitude and latitude values to the console
        console.log("Longitude:", longitude);
        console.log("Latitude:", latitude);

        // Membuat objek peta Leaflet dengan ID "map", mengatur tampilan peta ke koordinat longitude dan latitude, serta tingkat zoom 17
        var map = L.map('map').setView([latitude, longitude], 17);

        // Menambahkan marker ke peta pada koordinat longitude dan latitude yang telah diambil
        var marker = L.marker([latitude, longitude]).addTo(map);

        // Menambahkan layer peta menggunakan Google Maps Tiles API dengan subdomains mt0, mt1, mt2, dan mt3
        L.tileLayer('https://{s}.google.com/vt?/lyrs=p&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        // Mendefinisikan fungsi event click pada peta
        function onMapClick(e) {
            // Menampilkan informasi koordinat saat klik pada peta
            document.getElementById('InputLongitude').value = e.latlng.lng;
            document.getElementById('InputLatitude').value = e.latlng.lat;

            // Menghapus marker yang ada jika sudah ada
            if (marker) {
                map.removeLayer(marker);
            }

            // Menambahkan marker baru pada lokasi klik dan menampilkan popup dengan koordinat
            marker = L.marker(e.latlng).addTo(map)
                .bindPopup("Koordinat: " + e.latlng.toString())
                .openPopup();
        }

        // Menambahkan event listener untuk mendeteksi klik pada peta dan menjalankan fungsi onMapClick
        map.on('click', onMapClick);
    });
</script> -->


<!-- Akhir dari stack 'js' -->
@endpush