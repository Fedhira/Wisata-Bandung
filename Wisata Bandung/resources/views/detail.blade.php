@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">

                    <div class="card-body px-0 pt-0 pb-2">
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                        <!-- Elemen untuk peta -->
                        <div id="map" style="width:100%; height:500px;"></div>

                        <style>
                            #map {
                                width: 100%;
                                height: 500px;
                                top: 0;
                                /* Adjust this value based on your layout and preferences */
                            }
                        </style>
                        <!-- Akhir Elemen untuk peta -->
                        <br>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@push('js')
<script>
    // Convert PHP variable $tours to a JSON string
    var toursData = @json($tours);

    // Inisialisasi peta menggunakan Leaflet
    var map = L.map('map').setView([-6.900707, 107.615868], 13); // Set initial view to a default location (e.g., Jakarta)

    // Menambahkan layer peta dari Google Maps menggunakan Leaflet
    L.tileLayer('https://{s}.google.com/vt?/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 19,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    // Menambahkan marker untuk setiap wisata di dalam database
    toursData.forEach(function(tour) {
        var marker = L.marker([tour.latitude, tour.longitude]).addTo(map);
        marker.bindPopup("<b>" + tour.namatour + "</b><br>Alamat: " + tour.alamat + "<br>Jam Operasional: " + tour.jamoperasional + "<br>Biaya Masuk: " + tour.biayamasuk + "<br>Latitude: " + tour.latitude + "<br>Longitude: " + tour.longitude + "<br>Kontak: " + tour.kontak).openPopup();
    });

    // Menangkap event klik pada peta
    map.on('click', function onMapClick(e) {
        // Mendapatkan koordinat dari event klik
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // Mengisi nilai input latitude dan longitude
        document.getElementById('InputLatitude').value = lat;
        document.getElementById('InputLongitude').value = lng;
    });
</script>
@endpush