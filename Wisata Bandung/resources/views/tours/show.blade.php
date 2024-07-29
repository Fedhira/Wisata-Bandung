@extends('layouts.user_type.auth') <!-- Mendeklarasikan bahwa halaman ini akan menggunakan template dari AdminLTE. -->

<!--Menentukan judul halaman -->

@section('content_header') <!--Bagian header halaman untuk menampilkan judul. -->

<h1 class="m-0 text-dark">Data Wisata</h1>
<!-- Menambahkan stylesheet Leaflet CSS -->
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<!- Menambahkan script Leaflet JS -->
<!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script> -->

@stop <!-- Ini adalah direktif Blade yang menandakan akhir dari suatu bagian (section) dalam template -->

@section('content') <!-- Ini adalah direktif Blade yang menandakan dimulainya suatu section dengan nama 'content'. -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Menampilkan nama sekolah -->
                <h3><strong>{{ $tour->namatour }}</strong></h3>
                <br>

                <p><strong>Deskripsi:</strong> {{ $tour->deskripsi }}</p>

                <!-- Menampilkan alamat sekolah -->
                <p><strong>Alamat:</strong> {{ $tour->alamat }}</p>

                <p><strong>Jam Operasional:</strong> {{ $tour->jamoperasional}}</p>

                <!-- Menampilkan longitude sekolah dengan menyimpan data di atribut dataLongitude -->
                <p dataLongitude="{{ $tour->longitude }}"><strong>Longitude:</strong> {{ $tour->longitude }}</p>

                <!-- Menampilkan latitude sekolah dengan menyimpan data di atribut dataLatitude -->
                <p dataLatitude="{{ $tour->latitude }}"><strong>Latitude:</strong> {{ $tour->latitude }}</p>

                <p><strong>Biaya Masuk:</strong> {{ $tour->biayamasuk }}</p>
                <p><strong>Kontak:</strong> {{ $tour->kontak }}</p>
                <br>

                <!-- Tombol untuk kembali ke halaman indeks sekolah -->
                <a href="{{ route('tours.index') }}" class="btn btn-primary" style="margin-bottom: 20px;">Kembali</a>

                <!-- Bagian peta (Map) dengan tinggi 200px -->
                <div style="height: 400px;" id="map"></div>
            </div>
        </div>
    </div>
</div>


@stop <!-- Menandakan akhir dari section 'content', konten utama halaman akan ditempatkan di antara direktif @section('content') dan @stop -->

@push('dashboard') <!-- Menambahkan konten ke dalam sebuah stack bernama 'js' -->

<!-- Script JavaScript untuk menampilkan peta dengan Leaflet -->
<script>
    // Mengambil nilai latitude dari elemen dengan atribut dataLatitude
    var latitude = document.querySelector('p[dataLatitude]').getAttribute('dataLatitude');

    // Mengambil nilai longitude dari elemen dengan atribut dataLongitude
    var longitude = document.querySelector('p[dataLongitude]').getAttribute('dataLongitude');

    // Membuat objek peta Leaflet dengan menggunakan nilai latitude dan longitude & 17 adalah zoom level dari peta
    var map = L.map('map').setView([latitude, longitude], 17);

    // Menambahkan marker ke peta sesuai dengan nilai latitude dan longitude
    var marker = L.marker([latitude, longitude]).addTo(map);

    // Menambahkan layer peta dari Google Maps ke peta Leaflet
    L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 19,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    // Menambahkan pop-up dengan koordinat di atas marker
    marker.bindPopup("Koordinat: " + latitude + ", " + longitude).openPopup();
</script>
<!-- Akhir dari stack 'js' -->
@endpush