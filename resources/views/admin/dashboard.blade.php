@extends('admin.layouts.app')

{{-- Content --}}
@section('content')
<div class="page-heading">
    <h3>Dashboard</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-6 mt-4">
            <div class="card">
                <div class="card-body py-5 px-5">
                    <div class="d-flex flex-column align-items-start">
                        <h5 class="font-bold">Informasi Sistem</h5>
                        <p class="text-muted">
                            Sistem ini menggunakan teknologi <strong>Mapbox</strong> dengan framework <strong>Laravel</strong>. Tujuan utamanya adalah untuk mengetahui lokasi wisata di Sumba Barat, memudahkan pengguna dalam menemukan tempat wisata yang menarik dan mengakses informasi terkait lokasi tersebut secara detail.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-5 px-5">
                    <h5 class="font-bold mb-4">Selamat Datang</h5>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('admin/compiled/jpg/1.jpg') }}" alt="Profile Picture">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ $currentAdmin->nama }}</h5>
                            <h6 class="text-muted mb-0">{{ $currentAdmin->username }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column for Wisata and Admin counts -->
        <div class="col-6 col-lg-3 col-md-6 mt-5">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <a href="{{ route('admin.wisata') }}" class="stats-icon green mb-2">
                                <i class="iconly-boldBookmark"></i>
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Jumlah Wisata</h6>
                            <h6 class="font-extrabold mb-0">{{ $wisataCount }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <a href="{{ route('admin.akun') }}" class="stats-icon purple mb-2">
                                <i class="iconly-boldProfile"></i>
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Jumlah Admin</h6>
                            <h6 class="font-extrabold mb-0">{{ $adminCount }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
{{-- EndContent --}}
