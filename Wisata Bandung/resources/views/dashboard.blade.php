@extends('layouts.user_type.auth')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card p-4 aspect-ratio-1:1">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Data Wisata Bandung</p>
                <h5 class="font-weight-bolder mb-0">{{ \App\Models\TOUR::count() }} LOKASI</h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-4">
  <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-lg-6">
            <div class="d-flex flex-column h-100">
              <p class="mb-1 pt-2 text-bold">Jawa Barat,</p>
              <h5 class="font-weight-bolder">Kota Bandung</h5>
              <p class="mb-5 text-justify">Ibu kota yang sekaligus menjadi pusat pemerintahan dan perekonomian dari provinsi Jawa Barat, Indonesia. Kota Bandung juga merupakan kota terbesar keempat di Indonesia, setelah Jakarta, Surabaya, dan Medan.</p>
              <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="https://id.wikipedia.org/wiki/Kota_Bandung">
                Read More
                <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
            <div class="bg-gradient-primary border-radius-lg h-100">
              <img src="../assets/img/shapes/bandung.jpg" class="position-absolute h-100 w-40 top-0 d-lg-block d-none" alt="waves">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card h-100 p-3">
      <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/kawah-putih.jpg');">
        <span class="mask bg-gradient-dark"></span>
        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
          <h5 class="text-white font-weight-bolder mb-4 pt-2">Kawah Putih</h5>
          <p class="text-white">Kawah putih merupakan sebuah danau yang terbentuk dari letusan Gunung Patuha. </p>
          <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="https://id.wikipedia.org/wiki/Kawah_Putih">
            Read More
            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@push('dashboard')

@endpush