@extends('web.layouts.master')
@section('web-content')

@push('web-styles')
<style>
    #form {
        padding-top: 120px;
    }

    #mobil {
        margin: 50px 0;
    }

    #testimonial {
        /* margin-top: 50px; */
        /* padding: 100px 0; */
        background: linear-gradient(to bottom, var(--background), var(--yellow));
    }

    #testimonial h5 {
        font-size: 18px;
        font-weight: 500;
    }

</style>
@endpush

{{-- showLoginModal --}}
@if(session('showLoginModal'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    });
</script>
@endif

{{-- start form --}}
<section id="form">
    <div class="container my-5">
        <form>
            <div class="row g-2 align-items-center">
                <div class="col-md-9 col-sm-12">
                    <input type="text" class="form-control py-3" placeholder="Cari mobil...">
                </div>
                <div class="col-md-3 col-sm-12">
                    <button type="submit" class="btn w-100 py-3"
                        style="background-color: #fff04f; font-weight: bold;">CARI</button>
                </div>
            </div>

            <div class="row g-2 mt-3">
                <div class="col-4 col-sm-3">
                    <select class="form-select py-3">
                        <option selected disabled>Brand</option>
                        <option value="toyota">Toyota</option>
                        <option value="honda">Honda</option>
                        <!-- Tambahkan pilihan lainnya -->
                    </select>
                </div>
                <div class="col-4 col-sm-3">
                    <select class="form-select py-3">
                        <option selected disabled>Jarak Tempuh</option>
                        <option value="0-5000">0 - 5.000 km</option>
                        <option value="5000-10000">5.000 - 10.000 km</option>
                    </select>
                </div>
                <div class="col-4 col-sm-3">
                    <select class="form-select py-3">
                        <option selected disabled>Tahun</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <!-- Tambahkan tahun lainnya -->
                    </select>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- end form -->

<!-- start list mobil-->
<section id="mobil">
    <div class="container my-5">
        <h3 class="fw-bold mb-4">Mobil Tersedia</h3>
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4 col-6">
                <div class="card shadow-sm h-100 rounded-top">
                    <div class="ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center text-dark rounded-top "
                        style="font-weight: 500;">
                        Gambar Mobil
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Toyota Calya G AT 2020 Silver</h6>
                        <p class="mb-2" style="font-size: 14px;">2020 | 50.000 km | Automatic</p>
                        <p class="fw-bold mb-0">Rp 100.000.000</p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4 col-6">
                <div class="card shadow-sm h-100 rounded-top">
                    <div class="ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center text-dark rounded-top"
                        style="font-weight: 500;">
                        Gambar Mobil
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Toyota Calya G AT 2020 Silver</h6>
                        <p class="mb-2" style="font-size: 14px;">2020 | 50.000 km | Automatic</p>
                        <p class="fw-bold mb-0">Rp 100.000.000</p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4 col-6">
                <div class="card shadow-sm h-100 rounded-top">
                    <div class="ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center text-dark rounded-top"
                        style="font-weight: 500;">
                        Gambar Mobil
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Toyota Calya G AT 2020 Silver</h6>
                        <p class="mb-2" style="font-size: 14px;">2020 | 50.000 km | Automatic</p>
                        <p class="fw-bold mb-0">Rp 100.000.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- end list mobil -->

<!-- start testimonial -->
<section id="testimonial">
    <div class="container py-5">
        <h3 class="text-center fw-bold text-primary mb-5">Apa Kata Pelanggan Kami</h3>
        <div class="row g-4 justify-content-center">
            <!-- Testimonial Card -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="img-fluid" alt="Foto Pelanggan">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tarmidzi Bariq</h5>
                        <div class="mb-2 text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <p class="card-text text-muted" style="font-size: 14px;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the
                            industry's standard dummy text.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Duplikat 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="img-fluid" alt="Foto Pelanggan">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tarmidzi Bariq</h5>
                        <div class="mb-2 text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <p class="card-text text-muted" style="font-size: 14px;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the
                            industry's standard dummy text.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Duplikat 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" class="img-fluid" alt="Foto Pelanggan">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tarmidzi Bariq</h5>
                        <div class="mb-2 text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <p class="card-text text-muted" style="font-size: 14px;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the
                            industry's standard dummy text.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-end mt-4">
            <a href="#" class="text-dark  text-decoration-none d-inline-flex align-items-center">
                Lihat Yang Lain
                <span class="ms-2">→</span>
            </a>
        </div>
    </div>

</section>
<!-- end testimonial -->

<!-- Start About -->
<section id="about">
    <div class="py-5">
        <div class="container">
            <div class="row align-items-start">
                <!-- Kolom Foto -->
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="border rounded-3 overflow-hidden shadow-sm" style="height: 100%; max-height: 350px;">
                        <img src="{{asset('image/Tangkapan Layar 2025-05-20 pukul 16.42.21.png')}}"
                            alt="YONOMOBILINDO SHOWROOM" class="img-fluid w-100 h-100 object-fit-cover">
                    </div>
                </div>

                <!-- Kolom Teks -->
                <div class="col-lg-7">
                    <h4 class="fw-bold">Pak Sridaryono - Pemilik Showroom</h4>
                    <h3 class="fw-bold mb-4 text-uppercase">YONOMOBILINDO</h3>
                    <p class="text-muted">
                        Dengan pengalaman lebih dari 15 tahun di dunia otomotif, saya berkomitmen untuk menyediakan
                        mobil
                        berkualitas dengan harga terbaik di pasaran.
                        Setiap mobil yang ada di showroom ini telah melalui proses seleksi ketat dan pemeriksaan
                        menyeluruh untuk
                        memastikan kondisinya benar-benar prima.
                    </p>
                    <p class="text-muted">
                        Kepuasan pelanggan adalah prioritas utama kami. Kami sangat terbuka dalam memberikan
                        informasi tentang
                        kondisi mobil secara detail dan jujur.
                        Kami juga menyediakan layanan purna jual dan garansi untuk memberikan rasa aman dan nyaman
                        bagi para
                        pelanggan.
                    </p>

                    <!-- Statistik -->
                    <div class="row text-center mt-4">
                        <div class="col-4">
                            <h4 class="fw-bold">150+</h4>
                            <p class="mb-0">Mobil Terjual</p>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold">98%</h4>
                            <p class="mb-0">Pelanggan Puas</p>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold">15+</h4>
                            <p class="mb-0">Tahun Pengalaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End About -->

<!-- start form request Mobil -->
<section id="reqCar">
    <div class="py-5">
        <div class="container">
            <div class="mx-auto p-5 shadow rounded-3 bg-white" style="max-width: 900px;">
                <h3 class="fw-bold text-center mb-2">Belum Ketemu Mobilnya? Kami Bantu Cari!</h3>
                <p class="text-center text-muted mb-4">Isi detail mobil yang Anda cari, tim kami akan segera
                    menghubungi Anda.
                </p>

                <form>
                    <div class="mb-3">
                        <label for="carRequest" class="form-label fw-semibold">Merek, Mobil, Tahun<span
                                class="text-danger">*</span></label>
                        <input type="text" id="carRequest" class="form-control form-control-lg shadow-sm border-dark"
                            placeholder="Cth. Daihatsu Xenia 2024" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn px-4 py-2 fw-bold text-primary"
                            style="background-color: var(--yellow);">
                            Beritahu saya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<!-- end form request Mobil -->
@endsection


