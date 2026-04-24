@extends('web.layouts.master')
@section('web-content')
@push('web-styles')
<style>
    #formDP {
        padding-top: 100px;
        padding-bottom: clamp(3.5rem, 10vw, 6rem);
        overflow-x: hidden;
    }

    #formDP .form-control {
        background-color: #eeeeee;
        border-radius: 5px;

    }

    #formDP img {
        width: 100%;
        height: auto;
        border-radius: 5px;
    }

    #formDP .btn-submit {
        background-color: var(--primary);
        color: #fcf259;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 5px;
        border: none;
        transition: background-color 0.3s ease;
        margin-top: 0;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Kolom kanan tidak ikut meregang setinggi kolom form (hindari kartu “kosong” panjang). */
    #formDP .dp-sidebar-col {
        align-self: flex-start;
    }

    #formDP .dp-submit-wrap {
        margin-top: 1rem;
        padding-top: 0.25rem;
        padding-bottom: 0.5rem;
    }

    #formDP .dp-submit-hint {
        font-size: 0.8125rem;
        line-height: 1.45;
        color: #5c636a;
        margin-bottom: 0.75rem;
        padding: 0.6rem 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    /* #formDP .dp-summary-card .card-body {
        padding-top: 0.5rem;
        padding-bottom: 1rem;
    } */

    .amount-display {
        font-weight: 500;
        font-size: 16px;
    }

    #formDP .time-option-btn {
        border: 1px solid #ced4da;
        color: #212529;
        background-color: #eeeeee;
        font-size: 10px;
        border-radius: 30px;
    }

    #formDP .btn-check:checked + .time-option-btn {
        border-color: var(--primary);
        color: #fcf259;
        background-color: var(--primary);
    }

    #formDP .dp-page-title {
        margin-top: 0;
        margin-bottom: 0.35rem;
        line-height: 1.25;
    }

    /* Rapatkan judul halaman dengan baris form */
    #formDP .container > form.row {
        margin-top: 0;
    }

    #formDP .dp-form-card .card-body {
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
    }

    #formDP .dp-form-card .form-label {
        margin-bottom: 0.35rem;
    }

    #formDP .dp-summary-card .card-header {
        background: linear-gradient(135deg, rgba(39, 84, 138, 0.06) 0%, rgba(252, 242, 89, 0.12) 100%);
        padding-top: 0.65rem;
        padding-bottom: 0.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    #formDP .dp-summary-card .card-header .dp-summary-lead {
        margin-top: 0.35rem;
        margin-bottom: 0;
        line-height: 1.4;
    }

    #formDP .dp-summary-card .card-header h4 {
        margin-top: 0.35rem;
        margin-bottom: 0.15rem;
        line-height: 1.25;
        font-size: 1.2rem;
    }

    #formDP .dp-car-thumb-wrap {
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    #formDP .dp-car-thumb {
        display: block;
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    #formDP .dp-info-tile {
        background: #f1f3f5;
        border-radius: 8px;
        padding: 0.65rem 0.75rem;
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    #formDP .dp-info-tile .dp-info-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #6c757d;
        margin-bottom: 0.2rem;
    }

    #formDP .dp-info-tile .dp-info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #212529;
        line-height: 1.25;
    }

    #formDP .dp-location-box {
        background: #fffdf6;
        border: 1px solid rgba(39, 84, 138, 0.12);
        border-radius: 10px;
        padding: 0.85rem 1rem;
    }

</style>
@endpush

{{-- start formDP --}}
<section id="formDP">
    <div class="container">
        <h3 class="fw-bold dp-page-title">Pembayaran DP</h3>
        <form id="formDPSubmit" action="{{route('web.downPayment.store')}}" method="POST" class="row g-3 align-items-start">
                <!-- Kolom kiri: Form Tanggal dan Waktu -->
                @csrf
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                <div class="col-lg-7">
                    <div class="card border-0 p-2 shadow rounded-3 dp-form-card">
                        <div class="card-body">
                            <div class="mb-2">
                                <label for="tanggal" class="form-label fw-medium">Tanggal Janji Temu</label>
                                <input type="date" 
                                    name="appointment_date"
                                    class="form-control py-2 @error('appointment_date') is-invalid @enderror" 
                                    value="{{ old('appointment_date')}}"
                                    id="tanggal"
                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                @error('appointment_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="pt-1">
                                <label class="form-label fw-medium d-block">Waktu</label>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    @php
                                        $timeOptions = ['10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
                                    @endphp
                                    @foreach ($timeOptions as $timeOption)
                                        <input class="btn-check time-option-input"
                                            type="radio"
                                            name="appointment_time_option"
                                            id="waktu_{{ str_replace(':', '', $timeOption) }}"
                                            value="{{ $timeOption }}"
                                            autocomplete="off" 
                                            {{ old('appointment_time') === $timeOption ? 'checked' : '' }}>
                                        <label class="btn time-option-btn px-3 py-2"
                                            for="waktu_{{ str_replace(':', '', $timeOption) }}">
                                            {{ $timeOption }}
                                        </label>
                                    @endforeach
                                </div>
                                <input type="time"
                                    class="form-control py-2  @error('appointment_time') is-invalid @enderror"
                                    name="appointment_time"
                                    value="{{ old('appointment_time') }}"
                                    id="waktu">
                                
                                @error('appointment_time')
                                <span class="text-danger d-block mt-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kolom untuk jumlah DP -->
                    <div class="card border-0 p-2 shadow rounded-3 my-3 dp-form-card">
                        <div class="card-body">
                            <div>
                                <label for="jumlahDP" class="form-label fw-medium">Masukkan Jumlah DP || Minimal DP Rp
                                    100.000</label>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    @php
                                        $amountOptions = [100000, 200000, 300000, 400000, 500000];
                                    @endphp
                                    @foreach ($amountOptions as $amountOption)
                                        <input class="btn-check amount-option-input"
                                            type="radio"
                                            name="amount_option"
                                            id="amount_{{ $amountOption }}"
                                            value="{{ $amountOption }}"
                                            autocomplete="off"
                                            {{ (string) old('amount') === (string) $amountOption ? 'checked' : '' }}>
                                        <label class="btn time-option-btn px-3 py-2"
                                            for="amount_{{ $amountOption }}">
                                            {{ number_format($amountOption, 0, ',', '.') }}
                                        </label>
                                    @endforeach
                                </div>
                                {{-- <input type="text" class="form-control py-2 amount-display"
                                    placeholder="Ketik jumlah DP" name="amount" id="jumlahDP" /> --}}
                                <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount_format" value="" required />
                                <input type="hidden" name="amount" id="amount" value="{{ old('amount') }}" />
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom kanan: ringkasan mobil & submit -->
                <div class="col-lg-5 dp-sidebar-col">
                    @php
                        $dpPhotoUrl = $car->mainPhoto && Storage::disk('public')->exists('car_photos/' . $car->mainPhoto->photo_url)
                            ? asset('storage/car_photos/' . $car->mainPhoto->photo_url)
                            : asset('image/NoImage.png');
                        $dpTitle = trim($car->year . ' ' . $car->brand . ' ' . $car->model);
                    @endphp
                    <div class="card border-0 shadow rounded-3 dp-summary-card">
                        <div class="card-header border-0 rounded-top-3">
                            <span class="badge rounded-pill bg-light text-primary border border-primary border-opacity-25">
                                Janji temu &amp; DP
                            </span>
                            <h4 class="fw-bold">Ringkasan mobil</h4>
                            <p class="small text-muted dp-summary-lead">
                                Cek kembali unit yang Anda pilih sebelum mengisi tanggal, waktu, dan nominal DP.
                            </p>
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div class="dp-car-thumb-wrap mb-3">
                                <img src="{{ $dpPhotoUrl }}"
                                    alt="{{ $dpTitle }}"
                                    class="dp-car-thumb"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('image/NoImage.png') }}';">
                            </div>

                            <h5 class="fw-bold text-capitalize mb-2 lh-sm">{{ $dpTitle }}</h5>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                @if($car->color)
                                    <span class="badge rounded-pill bg-light text-dark border text-capitalize">
                                        {{ $car->color }}
                                    </span>
                                @endif
                                @if($car->status === 'available')
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                        Tersedia
                                    </span>
                                @endif
                            </div>

                            <div class="row g-2">
                                @if(!empty($car->price))
                                    <div class="col-sm-6">
                                        <div class="dp-info-tile">
                                            <div class="dp-info-label">Harga pasang</div>
                                            <div class="dp-info-value">Rp {{ number_format($car->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-6">
                                    <div class="dp-info-tile">
                                        <div class="dp-info-label">Kilometer</div>
                                        <div class="dp-info-value">{{ number_format($car->mileage, 0, ',', '.') }} km</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="dp-info-tile">
                                        <div class="dp-info-label">Transmisi</div>
                                        <div class="dp-info-value text-capitalize">{{ $car->transmission }}</div>
                                    </div>
                                </div>
                                @if(!empty($car->fuel_type))
                                    <div class="col-sm-6">
                                        <div class="dp-info-tile">
                                            <div class="dp-info-label">Bahan bakar</div>
                                            <div class="dp-info-value text-capitalize">{{ $car->fuel_type }}</div>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($car->engine))
                                    <div class="col-sm-6">
                                        <div class="dp-info-tile">
                                            <div class="dp-info-label">Mesin</div>
                                            <div class="dp-info-value">{{ $car->engine }}</div>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($car->seat))
                                    <div class="col-sm-6">
                                        <div class="dp-info-tile">
                                            <div class="dp-info-label">Kursi</div>
                                            <div class="dp-info-value">{{ $car->seat }} penumpang</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="dp-location-box mt-3">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 text-primary pt-1">
                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-semibold small text-uppercase text-muted mb-1">Lokasi mobil</div>
                                        <p class="mb-2 small lh-base">
                                            Pekapuran Jl 1000 RT 05/05, Sukamaju Baru, Tapos, Depok
                                        </p>
                                        <a class="small fw-semibold"
                                            href="https://maps.app.goo.gl/gRqiVoKQtVFzp52Q6"
                                            target="_blank"
                                            rel="noopener noreferrer">
                                            Buka di Google Maps <i class="fas fa-external-link-alt ms-1" style="font-size:0.75rem;" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('web.detailMobil', $car->id) }}"
                                class="btn btn-outline-secondary btn-sm w-100 mt-3 mb-0 d-inline-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                Lihat halaman detail mobil
                            </a>
                        </div>
                    </div>

                    <div class="dp-submit-wrap">
                        <p class="dp-submit-hint text-center mb-0">
                            Setelah dikirim, Anda akan diarahkan ke halaman checkout pembayaran.
                        </p>
                        <button type="submit" class="btn btn-submit">Lanjutkan pembayaran DP</button>
                    </div>
                </div>
        </form>
    </div>
</section>
{{-- end formDp --}}

@push('web-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>

    // Format input amount to Rupiah
    function formatRupiah(angka) {
        let numberString = angka.replace(/\D/g, "");
        let formatted = numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return numberString ? 'Rp ' + formatted : '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputFormatted = document.getElementById('amount_format');
        const inputHidden = document.getElementById('amount');
        const waktuInput = document.getElementById('waktu');
        const timeOptionInputs = document.querySelectorAll('.time-option-input');
        const amountOptionInputs = document.querySelectorAll('.amount-option-input');

        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            inputHidden.value = clean;

            const normalizedValue = clean;
            let hasMatchedAmount = false;
            amountOptionInputs.forEach((optionInput) => {
                const isMatch = optionInput.value === normalizedValue;
                optionInput.checked = isMatch;
                if (isMatch) hasMatchedAmount = true;
            });

            if (!hasMatchedAmount) {
                amountOptionInputs.forEach((optionInput) => {
                    optionInput.checked = false;
                });
            }
        });

        timeOptionInputs.forEach((optionInput) => {
            optionInput.addEventListener('change', function () {
                if (this.checked) {
                    waktuInput.value = this.value;
                }
            });
        });

        waktuInput.addEventListener('input', function () {
            const inputValue = this.value;
            let hasMatchedOption = false;

            timeOptionInputs.forEach((optionInput) => {
                const isMatch = optionInput.value === inputValue;
                optionInput.checked = isMatch;
                if (isMatch) hasMatchedOption = true;
            });

            if (!hasMatchedOption) {
                timeOptionInputs.forEach((optionInput) => {
                    optionInput.checked = false;
                });
            }
        });

        const selectedTimeOption = document.querySelector('.time-option-input:checked');
        if (selectedTimeOption && !waktuInput.value) {
            waktuInput.value = selectedTimeOption.value;
        }

        amountOptionInputs.forEach((optionInput) => {
            optionInput.addEventListener('change', function () {
                if (this.checked) {
                    inputFormatted.value = formatRupiah(this.value);
                    inputHidden.value = this.value;
                }
            });
        });

        if (inputHidden.value) {
            inputFormatted.value = formatRupiah(inputHidden.value);
        }

        const selectedAmountOption = document.querySelector('.amount-option-input:checked');
        if (selectedAmountOption && !inputHidden.value) {
            inputFormatted.value = formatRupiah(selectedAmountOption.value);
            inputHidden.value = selectedAmountOption.value;
        }
    });

    document.getElementById('formDPSubmit').addEventListener('submit', function (e) {
        e.preventDefault();

        const tanggal = document.getElementById('tanggal').value;
        const waktu = document.getElementById('waktu').value;
        const jumlahDP = document.getElementById('amount').value;

        if (!tanggal || !waktu || jumlahDP.trim() === '') {
            alert('Mohon lengkapi semua field yang diperlukan!');
            return;
        }

        const dpAmount = parseInt(jumlahDP.replace(/[^\d]/g, ''));
        if (dpAmount < 500000) {
            alert('Minimal DP adalah Rp 500.000');
            return;
        }

        this.submit(); // Lanjutkan submit
    });

</script>
@endpush
@endsection
