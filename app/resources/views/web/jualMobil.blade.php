@extends('web.layouts.master')
@section('web-content')

@push('web-styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet" />
<style>
        .select2-container--bootstrap-5 .select2-selection {
        padding: 0.5em 1rem;
        /* Sama seperti py-3 */
        height: auto !important;
        /* min-height: 48px; */
        /* Sesuaikan dengan input py-3 */
        border: 0px solid #ced4da;
        border-radius: 0.375rem;
        background-color:#eeeeee; 
        display: flex;
        align-items: center;
        /* Vertikal centering */
    }

    /* Hapus padding ganda dari teks */
    .select2-container--bootstrap-5 .select2-selection__rendered {
        padding: 0;
        margin: 0;
        /* line-height: normal; */
    }

    /* Hapus padding dari arrow dropdown */
    .select2-container--bootstrap-5 .select2-selection__arrow {
        top: 50%;
        transform: translateY(-50%);
    }
    #formJualMobil {
        padding-top: 170px;
    }

    #formJualMobil .form-control {
        background-color: #eeeeee;
        border-radius: 5px;
    }

    #formJualMobil .btn-submit {
        background-color: var(--primary);
        color: #fcf259;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        transition: background-color 0.3s ease;
        margin-top: 20px;
    }

    #tutorial .border {
        background-color: var(--background);
    }

    #tutorial .number {
        font-size: 48px;
        color: var(--grey, #867e77);
        font-weight: 700;
    }

    #tutorial .step-text {
        font-size: 16px;
        color: var(--black);
        font-weight: 700;
    }

    #tutorial img.step-icon {
        width: 70px;
    }

    @media (max-width: 576px) {
        #tutorial .number {
            font-size: 20px;
        }

        #tutorial .step-text {
            font-size: 12px;
            color: var(--black);
            font-weight: 700;
        }

        #tutorial img.step-icon {
            width: 40px;
        }

        #tutorial .step-text {
            font-size: 10px;
        }

        #tutorial .step-header {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        #tutorial .step-body {
            padding: 1rem 0.5rem;
        }
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
<!-- start formJualMobil -->
<section id="formJualMobil">
    <div class="container">
        <h3 class="fw-bold mb-5">FORM JUAL MOBIL</h3>
        <form action="{{route('web.jualMobil.store')}}" method="POST">
            @csrf
            <div class="row d-flex align-items-start">
                <div class="col-md-6 " style="font-size: 20px;">
                    <p class="fw-semibold mb-2">Informasi Mobil</p>
                    <p class="text-muted">Masukkan Spesifikasi Mobil Anda Secara Lengkap</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label fw-medium">Brand*</label>
                                <select name="brand" id="brand" class="form-control py-2 border-0" required>
                                    <option selected disabled>Ketik Atau Pilih</option>
                                    {{-- <option value="">-- Pilih Brand --</option> --}}
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand }}">{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="model" class="form-label fw-medium">Model*</label>
                                <select name="model" id="model" class="form-control py-2 border-0" required disabled>
                                    <option selected disabled>Ketik Atau Pilih</option>
                                    {{-- <option selected disabled>Brand</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="year" class="form-label fw-medium ">Tahun*</label>
                                <select name="year" id="year" class="form-control py-2 border-0" required>
                                    <option selected disabled>Ketik Atau Pilih</option>
                                    {{-- <option value="">Ketik Atau Pilih</option> --}}
                                    @for ($year = 2025; $year >= 2000; $year--)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mileage" class="form-label fw-medium">Jarak Tempuh (KM)*</label>
                                {{-- <input type="number" name="mileage" id="mileage"
                                    class="form-control py-2 @error('mileage') is-invalid @enderror"
                                    value="{{ old('mileage') }}" placeholder="Ketik" required /> --}}
                                <input type="text" class="form-control @error('mileage') is-invalid @enderror" id="mileage_format" value="{{ old('mileage') ? number_format(old('mileage'), 0, ',', '.') : '' }}" required />

                                <input type="hidden" name="mileage" id="mileage" value="{{ old('mileage') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                
                                <label for="offered_price" class="form-label fw-medium">Penawaran Harga*</label>
                                <input type="text" class="form-control py-2 @error('offered_price') is-invalid @enderror" id="offered_price_format"
                                    value="{{ old('offered_price') ? number_format(old('offered_price'), 0, ',', '.') : '' }}" required />

                                <input type="hidden" name="offered_price" id="offered_price" value="{{ old('offered_price') }}" />

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex align-items-start mt-5">
                <div class="col-md-6 " style="font-size: 20px;">
                    <p class="fw-semibold mb-2">Detail Inspeksi</p>
                    <p class="text-muted">Isi Lokasi dan Tanggal Inspeksi untuk Validasi Kondisi Kendaraan Anda</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location_inspection" class="form-label fw-medium">Lokasi Inspeksi*</label>
                                <select name="location_inspection" id="location_inspection"
                                    class="form-control py-2 border-0" required>
                                    <option value="">Ketik Atau Pilih</option>
                                    <option value="Rumah">Rumah</option>
                                    <option value="Datang Ke Showroom">Datang Ke Showroom</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspection_date" class="form-label fw-medium">Tanggal Inspeksi*</label>
                                <input type="date" name="inspection_date" class="form-control py-2 border-0"
                                    id="inspection_date" placeholder="Ketik" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @auth
                <div class="justify-content-end d-flex mt-3">
                    <button type="submit" class="btn btn-submit col-12 col-md-3">Submit</button>
                </div>
                @else
                <div class="justify-content-end d-flex mt-3">
                    <a href="{{ route('login', ['redirect' => request()->fullUrl()]) }}" class="btn btn-outline-primary fw-semibold  py-2" >
                        <span>Login untuk Jual Mobil</span><br>
                        <small class="fw-normal text-muted" style="font-size: 12px;">Akses fitur hanya untuk pengguna
                            terdaftar</small>
                    </a>
                </div>
            @endauth
        </form>
    </div>
</section>
<!-- end formJualMobil -->

<!-- start tutorial -->
<section id="tutorial" class="py-5 mt-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-5">Proses Beli Mobil</h3>
        <div class="row g-3">

            <!-- STEP 1 -->
            <div class="col-3">
                <div class="border rounded-3 h-100">
                    <div
                        class="py-1 py-md-3 border-bottom d-flex align-items-center justify-content-between px-3 step-header">
                        <span class="step-text">STEP</span>
                        <span class="number">01</span>
                    </div>
                    <div class="step-body py-2 py-md-4">
                        <img src="{{asset('image/Isi Data Mobil.svg')}}" alt="DP" class="step-icon mb-3">
                        <p class="fw-medium step-text mb-0">Isi Data Mobil & isi detail inspeksi</p>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="col-3">
                <div class="border rounded-3 h-100">
                    <div
                        class="py-1 py-md-3 border-bottom d-flex align-items-center justify-content-between px-3 step-header">
                        <span class="step-text">STEP</span>
                        <span class="number">02</span>
                    </div>
                    <div class="step-body py-2 py-md-4">
                        <img src="{{ asset('image/VERIFIKASI.svg')}}" alt="Verifikasi & Konfirmasi Jadwal"
                            class="step-icon mb-3">
                        <p class="fw-medium step-text mb-0">Verifikasi & Konfirmasi Jadwal</p>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="col-3">
                <div class="border rounded-3 h-100">
                    <div
                        class="py-1 py-md-3 border-bottom d-flex align-items-center justify-content-between px-3 step-header">
                        <span class="step-text">STEP</span>
                        <span class="number">03</span>
                    </div>
                    <div class="step-body py-2 py-md-4">
                        <img src="{{asset('image/Inspeksi.svg')}}" alt="Proses Inspeksi Mobi" class="step-icon mb-3">
                        <p class="fw-medium step-text mb-0">Proses Inspeksi Mobil</p>
                    </div>
                </div>
            </div>
            <!-- STEP 4 -->
            <div class="col-3">
                <div class="border rounded-3 h-100">
                    <div
                        class="py-1 py-md-3 border-bottom d-flex align-items-center justify-content-between px-3 step-header">
                        <span class="step-text">STEP</span>
                        <span class="number">04</span>
                    </div>
                    <div class="step-body py-2 py-md-4">
                        <img src="{{asset('image/Konfirmasi.svg')}}" alt="Konfirmasi dan Terima Penawaran"
                            class="step-icon mb-3">
                        <p class="fw-medium step-text mb-0">Konfirmasi dan Terima Penawaran</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- end tutorial -->

<!-- start testimonial -->
<section id="testimonial">

    <div class="container py-5">
        <h3 class="text-center fw-bold text-primary mb-5">Apa Kata Pelanggan Kami</h3>
        <div class="row g-4 justify-content-center">
            <!-- Testimonial Card -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" class="img-fluid" alt="Foto Pelanggan">
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
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the
                            industry's standard dummy text.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Duplikat 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" class="img-fluid" alt="Foto Pelanggan">
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
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the
                            industry's standard dummy text.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Duplikat 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" class="img-fluid" alt="Foto Pelanggan">
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
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the
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
@if(session('showLoginModal'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    });
</script>
@endif

@push('web-scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $('#brand, #model, #year').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: 'Ketik Atau Pilih',
        });

        $('#brand').on('change', function () {
            const brand = $(this).val();
            $('#model').prop('disabled', true).empty().append('<option value="">Loading...</option>');

            if (brand) {
                $.get('/api/models', {
                    brand: brand
                }, function (data) {
                    $('#model').empty().append('<option value="">-- Pilih Model --</option>');
                    $.each(data, function (i, model) {
                        $('#model').append(
                            `<option value="${model}">${model}</option>`);
                    });
                    $('#model').prop('disabled', false).trigger('change');
                });
            } else {
                $('#model').empty().append('<option value="">-- Pilih Model --</option>').prop(
                    'disabled', true);
            }
        });

    });


    // Format input offered_price to Rupiah
    function formatRupiah(angka) {
        let numberString = angka.replace(/\D/g, "");
        let formatted = numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return numberString ? 'Rp ' + formatted : '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputFormatted = document.getElementById('offered_price_format');
        const inputHidden = document.getElementById('offered_price');

        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            inputHidden.value = clean;
        });
    });

        // Format input mileage to Rupiah
    function formatMileage(angka) {
        return angka.replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputFormatted = document.getElementById('mileage_format');
        const inputHidden = document.getElementById('mileage');

        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatMileage(clean);
            inputHidden.value = clean;
        });
    });
</script>

@endpush
@endsection
