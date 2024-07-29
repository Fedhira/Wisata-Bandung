@extends('layouts.user_type.auth')


@section('content_header')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

@stop

@section('content')

<div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @if (session('success_message'))
                        <div class="alert alert-success">
                            {{session('success_message')}}
                        </div>
                        @endif
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Wisata
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Deskripsi
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Alamat
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Longitude
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Latitude
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jam Operasional
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Biaya Masuk
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kontak
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Looping untuk setiap sekolah dalam variabel $sekolahs -->
                                @foreach ($tours as $key => $tour)
                                <tr>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $tour->namatour }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $tour->deskripsi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $tour->alamat }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $tour->longitude }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $tour->latitude }} </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $tour->jamoperasional }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $tour->biayamasuk }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $tour->kontak }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('tours.show', $tour->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Lihat data"><i class="fas fa-eye"></i></a>

                                        <a href="{{ route('edit', ['id' => $tour->id]) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit data">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span>
                                            <form action="{{ route('tours.destroy', $tour->id) }}" id="delete-form-{{ $tour->id }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Tombol konfirmasi penghapusan dengan fungsi JavaScript -->
                                                <button type="button" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Hapus data" onclick="confirmDelete('{{ $tour->id }}')"><i class="fas fa-trash-alt text-secondary"></i></button>
                                            </form>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">

                <div class="card-body">
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

@stop <!-- Menandakan akhir dari section 'content', konten utama halaman akan ditempatkan di antara direktif @section('content') dan @stop -->

@push('dashboard')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<!-- Skrip JavaScript untuk konfirmasi penghapusan -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak dapat mengembalikan data yang sudah dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Trigger the form submission for delete
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush