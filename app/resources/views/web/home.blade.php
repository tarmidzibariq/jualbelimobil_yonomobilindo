@extends('web.layouts.master')
@section('web-content')

@push('web-styles')
<!-- CSS Select2 -->
<!-- CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Jika kamu pakai Bootstrap 5 dan ingin tampilan serasi -->
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet" />

<style>
    /* padding dan tinggi agar konsisten dengan py-3 input */
    .select2-container--bootstrap-5 .select2-selection {
        padding: 1rem 1rem;
        /* Sama seperti py-3 */
        height: auto !important;
        min-height: 48px;
        /* Sesuaikan dengan input py-3 */
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        /* Vertikal centering */
    }

    /* Hapus padding ganda dari teks */
    .select2-container--bootstrap-5 .select2-selection__rendered {
        padding: 0;
        margin: 0;
        line-height: normal;
    }

    /* Hapus padding dari arrow dropdown */
    .select2-container--bootstrap-5 .select2-selection__arrow {
        top: 50%;
        transform: translateY(-50%);
    }

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
        <form action="{{ route('home') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-md-9 col-sm-12">
                    <input name="q" type="text" class="form-control py-3" placeholder="Cari mobil..."
                        value="{{ request('q') }}">
                </div>
                <div class="col-md-3 col-sm-12">
                    <button type="submit" class="btn w-100 py-3"
                        style="background-color: #fff04f; font-weight: bold;">CARI</button>
                </div>
            </div>

            <div class="row g-2 mt-3">
                <div class="col-4 col-sm-3">
                    <select name="brand" class="form-select py-3 brand" data-placeholder="-- Pilih Brand --">
                        <option selected disabled>Brand</option>
                        {{-- <option></option> --}}
                        @foreach ($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4 col-sm-3">
                    <select name="mileage" class="form-select py-3 mileage">
                        <option selected disabled>Jarak Tempuh</option>

                        @for ($i = 0; $i < 100000; $i +=10000) @php $min=$i; $max=$i + 10000; $value="$min-$max" ;
                            @endphp <option value="{{ $value }}" {{ request('mileage') == $value ? 'selected' : '' }}>
                            {{ number_format($min, 0, ',', '.') }} - {{ number_format($max, 0, ',', '.') }} km
                            </option>
                            @endfor

                            {{-- Opsi tambahan: 100.000+ km --}}
                            <option value="100000-999999" {{ request('mileage') == '100000-999999' ? 'selected' : '' }}>
                                100.000+ km
                            </option>
                    </select>
                </div>
                <div class="col-4 col-sm-3">
                    <select name="year" class="form-select py-3 year">
                        <option selected disabled>Tahun</option>
                        @for ($year = 2025; $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                        </option>
                        @endfor
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
            @forelse ($cars as $item)
            <div class="col-md-4 col-6">
                <div class="card shadow-sm h-100 rounded-top">
                    <div
                        class="ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center text-dark rounded-top">
                        <img src="{{ $item->mainPhoto && Storage::disk('public')->exists('car_photos/' . $item->mainPhoto->photo_url)
                    ? asset('storage/car_photos/' . $item->mainPhoto->photo_url)
                    : asset('image/NoImage.png') }}" alt="{{ $item->brand }} {{ $item->model }}"
                            class="img-fluid object-fit-cover w-100 h-100 rounded-top">
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold text-capitalize">{{ $item->brand }} {{ $item->model }}
                            {{ $item->year }} </h6>
                        <p class="mb-2 text-capitalize" style="font-size: 14px;">
                            {{ $item->year }} | {{ $item->mileage }} km | {{ $item->transmission }}
                        </p>
                        <p class="fw-bold mb-0">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <h4 class="text-muted mb-3 text-capitalize">{{ request('q') ?? ' ' }} {{ request('brand') ?? ' ' }} {{ request('mileage') ?? ' ' }} {{ request('year') ?? ' ' }}Tidak Ditemukan</h4>

                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Reset Filter</a>
            </div>

            @endforelse



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

@push('web-scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.brand, .mileage , .year').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: '-- Pilih --',

        });
    });

</script>
@endpush

@endsection
