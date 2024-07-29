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
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/wayang.jpg'); background-position-y: 50%;">

        </div>

    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Input Data Wisata</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('tours.store') }}" method="POST" role="form text-left">
                        @csrf
                        <div class="mb-3">
                            <label for="LabelNama" class="form-label">Nama Wisata</label>
                            <div>
                                <input type="text" class="form-control" id="InputNama" name="namatour" placeholder="Nama Wisata">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelAlamat" class="form-label">Alamat Wisata</label>
                            <div>
                                <input type="text" class="form-control" id="InputAlamat" name="alamat" placeholder="Alamat Wisata">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelJamOperasional" class="form-label">Jam Operasional</label>
                            <div>
                                <input type="text" class="form-control" id="InputJamOperasional" name="jamoperasional" placeholder="Jam Operasional">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelBiayaMasuk" class="form-label">Biaya Masuk</label>
                            <div>
                                <input type="text" class="form-control" id="InputBiayaMasuk" name="biayamasuk" placeholder="Rp.">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelLatitude" class="form-label">Latitude</label>
                            <div>
                                <input type="text" class="form-control" id="InputLatitude" name="latitude" placeholder="Latitude">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelLongitude" class="form-label">Longitude</label>
                            <div>
                                <input type="text" class="form-control" id="InputLongitude" name="longitude" placeholder="Longitude">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelKontak" class="form-label">Kontak</label>
                            <div>
                                <input type="text" class="form-control" id="InputKontak" name="kontak" placeholder="08xxxx">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="LabelDeskripsi" class="form-label">Deskripsi</label>
                            <div>
                                <input type="text" class="form-control" id="InputDeskripsi" name="deskripsi" placeholder="say something about tourism in Bandung" name="deskripsi">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="about">Deskripsi</label>
                            <div>
                                <textarea class="form-control" id="InputDeskripsi" rows="3" placeholder="say something about tourism in Bandung" name="deskripsi"></textarea>
                            </div>
                        </div> -->

                        <!-- Bagian peta (Map) dengan tinggi 400px -->
                        <div style="height: 400px;" id="map"></div>

                        <style>
                            #map {
                                width: 100%;
                                height: 500px;
                                top: 0;
                                /* Adjust this value based on your layout and preferences */
                            }
                        </style>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
    var map = L.map('map').setView([-6.873584513844985, 107.57570825178068], 19);

    // var map = L.map('map').setView([-6.8931149, 107.6090784], 15);
    L.tileLayer('https://{s}.google.com/vt?/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 19, // Minumun tingkat zoom
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // GOOGLE MAPS
    // L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
    //     maxZoom: 20,
    //     subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    // }).addTo(map);

    // OPEN STREET MAP
    // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     maxZoom: 19,
    //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    // }).addTo(map);

    //-- google tiles ---- untuk memberi tahu bahwa bagian berikutnya adalah penjelasan tentang jenis peta dari Google Maps.

    // Hybrid: s,h; jenis peta Hybrid, s (Satellite) atau h (Streets) sebagai subdomain.
    // Satellite: s; jenis peta Satellite, menggunakan subdomain s.
    // Streets: m; jenis peta Streets, menggunakan subdomain m.
    // Terrain: p;  jenis peta Terrain, menggunakan subdomain p.




    // MARKER

    // Deklarasi variabel marker untuk menyimpan objek marker
    var marker; // Mendeklarasikan variabel marker untuk menyimpan objek marker

    // Fungsi yang akan dipanggil saat pengguna melakukan klik pada peta
    function onMapClick(e) {
        // Mengatur nilai input latitude dengan latitude dari titik klik
        document.getElementById('InputLatitude').value = e.latlng.lat;

        // Mengatur nilai input longitude dengan longitude dari titik klik
        document.getElementById('InputLongitude').value = e.latlng.lng;

        // Menghapus marker jika sudah ada sebelumnya
        if (marker) {
            map.removeLayer(marker);
        }

        // Membuat marker baru di lokasi klik, menambahkannya ke peta,
        // dan menampilkan popup dengan koordinat
        marker = L.marker(e.latlng).addTo(map)
            .bindPopup("Koordinat: " + e.latlng.toString())
            .openPopup();
    }

    // Menambahkan event listener untuk menangkap klik pada peta dan memanggil fungsi onMapClick
    map.on('click', onMapClick);






    // POLYLINE
    // GADA KOORDINAT

    // Variabel marker dan linearray digunakan untuk menyimpan objek marker dan array koordinat yang dipilih oleh pengguna
    // var marker;
    // var linearray = [];
    // var polyline; // Perhatikan bahwa terdapat deklarasi variabel dengan nama yang sama (polyline) seperti pada baris sebelumnya

    // // Menambahkan event listener untuk menangkap klik pada peta dan menjalankan fungsi onMapClick
    // map.on('click', function onMapClick(e) {
    //     // Mengambil nilai latitude dan longitude dari titik klik
    //     latitude = e.latlng.lat;
    //     longitude = e.latlng.lng;

    //     // Mengatur nilai input latitude dan longitude dengan koordinat yang dipilih
    //     // if (!marker) {
    //     //     document.getElementById('InputLatitude').value = latitude;
    //     //     document.getElementById('InputLongitude').value = longitude;
    //     // }

    //     document.getElementById('InputLatitude').value = latitude;
    //     document.getElementById('InputLongitude').value = longitude;
    //     // Menambahkan koordinat yang dipilih ke dalam array linearray
    //     linearray.push([latitude, longitude]);

    //     // Menambahkan marker baru di lokasi klik
    //     marker = L.marker([latitude, longitude]).addTo(map);

    //     // Menghapus polyline sebelumnya jika sudah ada
    //     if (polyline) {
    //         map.removeLayer(polyline);
    //     }

    //     // Membuat polyline baru dengan menggunakan array linearray dan mengatur warnanya menjadi merah
    //     polyline = L.polyline(linearray, {
    //         color: 'red'
    //     }).addTo(map);
    // });


    // POLYLINE ADA KOORDINAT

    // var marker;
    // var linearray = [];
    // var polyline;

    // // Menambahkan event listener untuk menangkap klik pada peta dan menjalankan fungsi
    // map.on('click', function(e) {
    //     // Mengambil nilai latitude dan longitude dari titik klik
    //     var lat = e.latlng.lat;
    //     var lng = e.latlng.lng;

    //     // Mengubah koordinat menjadi string
    //     var coord = e.latlng.toString();

    //     // Membuat dan menampilkan marker di lokasi klik
    //     marker = L.marker(e.latlng).addTo(map)
    //         .bindPopup("Koordinat: " + coord)
    //         .openPopup();

    //     // Menambahkan koordinat ke dalam array linearray
    //     linearray.push([lat, lng]);

    //     // Memeriksa apakah sudah ada lebih dari satu koordinat dalam linearray
    //     if (linearray.length > 1) {
    //         // Memeriksa apakah sudah ada polyline sebelumnya
    //         if (polyline) {
    //             // Menghapus polyline sebelumnya jika ada
    //             map.removeLayer(polyline);
    //         }

    //         // Membuat dan menampilkan polyline baru dengan menggunakan array linearray dan mengatur warnanya menjadi merah
    //         polyline = L.polyline(linearray, {
    //             color: 'red'
    //         }).addTo(map);
    //     }

    //     // Mengatur nilai input latitude dan longitude dengan koordinat yang dipilih
    //     document.getElementById('InputLatitude').value = lat;
    //     document.getElementById('InputLongitude').value = lng;
    // });


    // COBA POLYLINE & POLYGON
    // var marker;
    // var linearray = [];
    // var polyline;

    // map.on('click', function onMapClick(e) {
    //     latitude = e.latlng.lat;
    //     longitude = e.latlng.lng;
    //     document.getElementById('InputLatitude').value = latitude;
    //     document.getElementById('InputLongitude').value = longitude;
    //     linearray.push([latitude, longitude]);

    //     if (marker != null) {
    //         map.removeLayer(marker);
    //     }

    //     marker = L.marker([latitude, longitude]).addTo(map);
    //     polyline = L.polyline(linearray, {
    //         color: 'red'
    //     }).addTo(map);
    // });





    // POLYGON

    // var marker; // Variabel untuk menyimpan objek marker
    // var linearray = []; // Array untuk menyimpan koordinat dari setiap klik
    // var polygon; // Variabel untuk menyimpan objek poligon

    // // Menambahkan event listener untuk menangkap klik pada peta dan menjalankan fungsi onMapClick
    // map.on('click', function onMapClick(e) {
    //     // Mengambil nilai latitude dan longitude dari titik klik
    //     latitude = e.latlng.lat;
    //     longitude = e.latlng.lng;

    //     // Mengatur nilai input latitude dan longitude dengan koordinat yang dipilih
    //     document.getElementById('InputLatitude').value = latitude;
    //     document.getElementById('InputLongitude').value = longitude;

    //     // Menambahkan koordinat ke dalam array linearray
    //     linearray.push([latitude, longitude]);

    //     // Menambahkan marker baru di lokasi klik
    //     marker = L.marker([latitude, longitude]).addTo(map);

    //     // Membuat atau memperbarui poligon dengan menggunakan array linearray dan mengatur warnanya menjadi merah
    //     // (Perhatikan bahwa poligon akan membentuk area tertutup)
    //     if (polygon) {
    //         // Jika poligon sudah ada, hapus poligon sebelumnya dari peta
    //         map.removeLayer(polygon);
    //     }
    //     polygon = L.polygon(linearray, {
    //         color: 'red'
    //     }).addTo(map);
    // });



    // POLYGON ADA KOORDINAT

    // var marker; // Variabel untuk menyimpan objek marker
    // var linearray = []; // Array untuk menyimpan koordinat dari setiap klik
    // var polygon; // Variabel untuk menyimpan objek poligon

    // map.on('click', function(e) {
    //     var lat = e.latlng.lat;
    //     var lng = e.latlng.lng;
    //     var coord = e.latlng.toString();

    //     // Membuat atau memperbarui marker di lokasi klik
    //     marker = L.marker(e.latlng).addTo(map)
    //         .bindPopup("Koordinat: " + coord)
    //         .openPopup();

    //     // Menambahkan koordinat ke dalam array linearray
    //     linearray.push([lat, lng]);

    //     // Jika sudah ada lebih dari satu koordinat, dan poligon sudah ada sebelumnya, hapus poligon sebelumnya
    //     if (linearray.length > 1 && polygon) {
    //         map.removeLayer(polygon);
    //     }

    //     // Membuat atau memperbarui poligon dengan menggunakan array linearray dan mengatur warnanya menjadi merah
    //     // (Perhatikan bahwa poligon akan membentuk area tertutup)
    //     polygon = L.polygon(linearray, {
    //         color: 'red'
    //     }).addTo(map);

    //     // Menampilkan nilai latitude dan longitude di elemen input
    //     document.getElementById('InputLatitude').value = lat;
    //     document.getElementById('InputLongitude').value = lng;
    // });







    // CIRCLE

    // var marker;
    // var circle;

    // map.on('click', function onMapClick(e) {
    //     // Mengambil nilai latitude dan longitude dari titik klik
    //     latitude = e.latlng.lat;
    //     longitude = e.latlng.lng;

    //     // Mengatur nilai input latitude dan longitude dengan koordinat yang dipilih
    //     document.getElementById('InputLatitude').value = latitude;
    //     document.getElementById('InputLongitude').value = longitude;

    //     // Menghapus marker jika sudah ada sebelumnya
    //     if (marker) {
    //         map.removeLayer(marker);
    //     }

    //     // Menghapus lingkaran jika sudah ada sebelumnya
    //     if (circle) {
    //         map.removeLayer(circle);
    //     }
    //     // Membuat marker baru di lokasi klik
    //     marker = L.marker([latitude, longitude]).addTo(map);

    //     // Membuat lingkaran baru di lokasi klik dengan warna tepi hijau dan jari-jari sebesar 100
    //     circle = L.circle([latitude, longitude], {
    //         color: 'green', // Mengatur warna tepi lingkaran menjadi hijau
    //         radius: 20 // Mengatur jari-jari lingkaran
    //     }).addTo(map);
    // });




    // CIRCLE KOORDINAT

    // var marker; // Variabel untuk menyimpan objek marker
    // var circle; // Variabel untuk menyimpan objek lingkaran
    // function onMapClick(e) {
    //     // Mengatur nilai input latitude dengan latitude dari titik klik
    //     document.getElementById('InputLatitude').value = e.latlng.lat;

    //     // Mengatur nilai input longitude dengan longitude dari titik klik
    //     document.getElementById('InputLongitude').value = e.latlng.lng;

    //     // Menghapus marker jika sudah ada sebelumnya
    //     if (marker) {
    //         map.removeLayer(marker);
    //     }

    //     // Menghapus lingkaran jika sudah ada sebelumnya
    //     if (circle) {
    //         map.removeLayer(circle);
    //     }

    //     // Membuat marker baru di lokasi klik dengan popup yang menampilkan koordinat
    //     marker = L.marker(e.latlng).addTo(map)
    //         .bindPopup("Koordinat: " + e.latlng.toString())
    //         .openPopup();

    //     // LATITUDE SAJA
    //     // marker = L.marker(e.latlng).addTo(map)
    //     //     .bindPopup("Latitude: " + e.latlng.lat.toFixed(6)) // Menampilkan latitude dengan 6 angka di belakang koma
    //     // .openPopup();

    //     // Membuat lingkaran baru di lokasi klik dengan warna tepi hijau dan jari-jari sebesar 100
    //     circle = L.circle(e.latlng, {
    //         color: 'green', // Mengatur warna tepi lingkaran menjadi hijau
    //         radius: 200 // Mengatur jari-jari lingkaran
    //     }).addTo(map);
    // }

    // // Menambahkan event listener untuk menangkap klik pada peta dan memanggil fungsi onMapClick
    // map.on('click', onMapClick);
</script>
@endpush