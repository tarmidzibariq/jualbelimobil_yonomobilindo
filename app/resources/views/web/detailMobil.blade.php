@extends('web.layouts.master')
@section('web-content')

@push('web-styles')
<style>
    #detail-mobil {
        padding-top: 120px;
    }

    /* Buat wrapper untuk kontrol ukuran tetap */
    .main-img-wrapper {
        width: 100%;
        height: 300px;
        /* Ukuran konsisten */
        overflow: hidden;
        border-radius: 8px;
    }

    .main-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* Gambar tidak dipotong */
        object-position: center;
    }


    .thumb-img {
        width: 80px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.2s;
    }

    .thumb-img.active,
    .thumb-img:hover {
        border-color: #27548a;
    }

    .thumbnail-scroll {
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .thumbnail-scroll::-webkit-scrollbar {
        display: none;
    }

    .scroll-button {
        width: 35px;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        border: none;
        position: absolute;
        top: 0;
        z-index: 10;
    }

    .scroll-left {
        left: 0;
    }

    .scroll-right {
        right: 0;
    }

</style>
@endpush
<!-- start detail Mobil -->
<section id="detail-mobil">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Gambar Mobil -->
            <div class="col-lg-6">
                <!-- Wrapper gambar utama -->
                <div class="main-img-wrapper mb-3">
                    <img id="mainImage" src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="main-img"
                        data-bs-toggle="modal" data-bs-target="#zoomModal" alt="Mobil" style="cursor: zoom-in;">
                </div>

                <!-- Modal Zoom -->
                <div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body text-center p-0">
                                <img id="zoomImage" src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png"
                                    class="img-fluid w-100" alt="Zoom Preview">
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Thumbnail scroll area -->
                <div class="position-relative">
                    <!-- Scroll Buttons -->
                    <button class="scroll-button scroll-left border-0" onclick="scrollThumbnails(-1)"><i
                            class="fas fa-chevron-left"></i></button>
                    <button class="scroll-button scroll-right border-0" onclick="scrollThumbnails(1)"><i
                            class="fas fa-chevron-right"></i></button>

                    <!-- Thumbnails -->
                    <div id="thumbnailContainer" class="thumbnail-scroll d-flex gap-2 px-5">
                        <!-- Thumbnails: Tambahkan lebih dari 5 untuk test -->
                        <img src="Frame 100.svg" class="thumb-img rounded" onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                        <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="thumb-img rounded"
                            onclick="switchImage(this)">
                    </div>
                </div>
            </div>

            <!-- Detail Mobil -->
            <div class="col-lg-6">
                <h3 class="fw-bold">2021 - Toyota AVANZA VELOZ SILVER</h3>
                <p>50.000 KM | Automatic</p>
                <h5 class="text-danger fw-bold">Rp 300.000.000</h5>


                <div class="d-flex justify-content-between border-bottom border-1 border-dark py-2">
                    <strong>Warna</strong>
                    <span>Silver</span>
                </div>
                <div class="d-flex justify-content-between border-bottom border-1 border-dark py-2">
                    <strong>Jenis Bahan Bakar</strong>
                    <span>Bensin</span>
                </div>

                <p class="fw-semibold mb-1 mt-3">Lokasi Mobil:</p>
                <p class="text-muted">Pekapuran Jl 1000 RT 06/05 NO 200 SUKAMAJU BARU TAPOS DEPOK</p>

                <!-- Tombol -->
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button class="btn btn-primary fw-semibold px-5 py-2" style="background-color: var(--primary);">
                        <span style="color: var(--yellow);">DP Sekarang</span><br> <small class="fw-normal text-white"
                            style="font-size: 12px;">Min: Rp 500.000</small>
                    </button>
                    <button class="btn btn-outline-secondary rounded-circle" style="width: 45px; height: 45px;">
                        <i class="fas fa-share-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- end detail mobil -->

<!-- start tutorial -->
<section id="tutorial" class="py-5">
    <div class="container text-center bg-white py-5">
        <h3 class="fw-bold mb-5">PROSES BELI MOBIL</h3>
        <div class="row g-3 justify-content-center">

            <!-- STEP 1 -->
            <div class="col-4 col-lg-3">
                <div class="border rounded-3 h-100">
                    <div
                        class="py-1 py-md-3 border-bottom d-flex align-items-center justify-content-between px-3 step-header">
                        <span class="fw-bold">STEP</span>
                        <span class="number">01</span>
                    </div>
                    <div class="step-body py-4">
                        <img src="Isi Data Mobil.svg" alt="DP" class="step-icon mb-3">
                        <p class="fw-medium step-text mb-0">Melakukan DP</p>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="col-4 col-lg-3">
                <div class="border rounded-3 h-100">
                    <div
                        class="py-1 py-md-3 border-bottom d-flex align-items-center justify-content-between px-3 step-header">
                        <span class="fw-bold">STEP</span>
                        <span class="number">02</span>
                    </div>
                    <div class="step-body py-4">
                        <img src="Frame 3 1.svg" alt="Test Drive" class="step-icon mb-3">
                        <p class="fw-medium step-text mb-0">Test Drive</p>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="col-4 col-lg-3">
                <div class="border rounded-3 h-100">
                    <div
                        class="py-1 py-md-3 border-bottom d-flex align-items-center justify-content-between px-3 step-header">
                        <span class="fw-bold">STEP</span>
                        <span class="number">03</span>
                    </div>
                    <div class="step-body py-4">
                        <img src="Frame 4 1.svg" alt="Pembayaran" class="step-icon mb-3">
                        <p class="fw-medium step-text mb-0">Selesaikan<br>Pembayaran</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- end tutorial -->

<!-- start Kelengkapan -->
<section id="Tools" class=" ">
    <div class="container pt-5 border-top border-1 border-dark">
        <h3 class="fw-bold mb-4">Kelengkapan</h3>
        <div class="row g-3">

            <!-- Item 1 -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded shadow-sm p-3 text-center h-100">
                    <h6 class="fw-bold mb-1">BPKB</h6>
                    <p class="mb-0">Ya</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded shadow-sm p-3 text-center h-100">
                    <h6 class="fw-bold mb-1">Kunci Serep</h6>
                    <p class="mb-0">Ya</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded shadow-sm p-3 text-center h-100">
                    <h6 class="fw-bold mb-1">Buku Manual</h6>
                    <p class="mb-0">Ya</p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="col-6 col-md-3">
                <div class="bg-white rounded shadow-sm p-3 text-center h-100">
                    <h6 class="fw-bold mb-1">Buku Service</h6>
                    <p class="mb-0">Ya</p>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- end Kelengkapan -->

<!-- Start Ringkasan -->
<section class="mt-5">
    <div class="container">
        <h3 class="fw-bold mb-4">Ringkasan</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Brand dan Merek</span>
                    <span>Toyota Avanza Veloz</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Tahun Produksi</span>
                    <span>2021</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Transmisi</span>
                    <span>Automatic</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Bahan Bakar</span>
                    <span>Bensin</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Warna</span>
                    <span>Silver</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Jarak Tempuh</span>
                    <span>71.000 KM</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Jumlah Tempat Duduk</span>
                    <span>3 Orang</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">CC Mesin</span>
                    <span>2.500 CC</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Pajak</span>
                    <span>21 Juli 2024</span>
                </div>
                <div class="mb-3 pb-2 border-bottom border-1 border-dark d-flex justify-content-between">
                    <span class="fw-semibold">Servis Terakhir</span>
                    <span>21 Juli 2024</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Ringkasan -->

<!-- Start Deskripsi -->
<section class="mt-4">
    <div class="container">
        <h3 class="fw-bold mb-4">Deskripsi</h3>
        <p style="line-height: 1.8;">
            Toyota Alphard menjadi salah satu mobil MPV mewah dengan angka penjualan yang cukup tinggi.
            Ukuran yang besar dengan interior yang mewah menjadikan mobil ini sebagai mobil standar bagi
            kalangan menengah atas di Indonesia. Segera jadwalkan untuk informasi lebih lanjut.
        </p>
        <p style="line-height: 1.8;">
            Carro hadir untuk memberikan pelayanan pengiriman terbaik dan teraman yang menjangkau seluruh area
            Indonesia.
            Mobil akan diantarkan sesuai dengan kota tujuan Anda.
        </p>
    </div>
</section>
<!-- End Deskripsi -->

<!-- Start Keamanan -->
<section class="my-5 text-center">
    <div class="container">
        <h3 class="fw-bold mb-5">Semua Bebas</h3>
        <div class="row justify-content-center g-4">

            <!-- Bebas Kebakaran -->
            <div class="col-12 col-md-4">
                <img src="{{ asset('image/Frame 100.svg')}}" width="120" alt="Bebas Kebakaran" class="mb-3">
                <h6 class="fw-bold">Bebas Kebakaran</h6>
                <p class="mb-0">
                    Telah melalui inspeksi menyeluruh untuk memastikan bebas dari riwayat kebakaran.
                </p>
            </div>

            <!-- Bebas Kecelakaan -->
            <div class="col-12 col-md-4">
                <img src="{{ asset('image/Frame 101.svg')}}" width="120" alt="Bebas Kecelakaan" class="mb-3">
                <h6 class="fw-bold">Bebas Kecelakaan</h6>
                <p class="mb-0">
                    Terjaga dari kerusakan akibat kecelakaan, kondisi prima!
                </p>
            </div>

            <!-- Bebas Kebanjiran -->
            <div class="col-12 col-md-4">
                <img src="{{ asset('image/Frame 102.svg')}}" width="120" alt="Bebas Kebanjiran" class="mb-3">
                <h6 class="fw-bold">Bebas Kebanjiran</h6>
                <p class="mb-0">
                    Dijamin bukan mobil bekas banjir, aman dan nyaman dikendarai!
                </p>
            </div>

        </div>
    </div>
</section>
<!-- End Keamanan -->
@endsection
