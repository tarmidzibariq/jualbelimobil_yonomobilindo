@extends('web.layouts.master')
@section('web-content')
@push('web-styles')
<style>
    #formDP {
        padding-top: 170px;
        padding-bottom: 70px;
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
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        transition: background-color 0.3s ease;
        margin-top: 20px;
    }

    .amount-display {
        font-weight: 500;
        font-size: 16px;
    }

</style>
@endpush

{{-- start formDP --}}
<section id="formDP">
    <div class="container">
        <h3 class="fw-bold mb-5">Pembayaran DP</h3>
        <div class="row">
            <form id="formDPSubmit" action="{{route('web.downPayment.store')}}" method="POST" class="row">
                <!-- Kolom kiri: Form Tanggal dan Waktu -->
                @csrf
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                <div class="col-lg-7">
                    <div class="card border-0 p-3 shadow rounded-3">
                        <div class="card-body">
                            <div class="mb-3">
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
                            <div>
                                <label for="waktu" class="form-label fw-medium">Waktu</label>
                                <input type="time"
                                    class="form-control py-2 @error('appointment_time') is-invalid @enderror"
                                    name="appointment_time" value="{{old('appointment_time')}}" id="waktu">
                                @error('appointment_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kolom untuk jumlah DP -->
                    <div class="card border-0 p-3 shadow rounded-3 my-5">
                        <div class="card-body">
                            <div>
                                <label for="jumlahDP" class="form-label fw-medium">Masukkan Jumlah DP || Minimal DP Rp
                                    500.000</label>
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

                <!-- Kolom kanan: Info Mobil -->
                <div class="col-lg-5">
                    <div class="card border-0 p-3 shadow rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5 mb-3 mb-md-0">
                                    <img src="{{ $car->mainPhoto && Storage::disk('public')->exists('car_photos/' . $car->mainPhoto->photo_url)
                    ? asset('storage/car_photos/' . $car->mainPhoto->photo_url)
                    : asset('image/NoImage.png') }}" alt="{{ $car->brand }} {{ $car->model }}" class=" img-fluid" />
                                </div>
                                <div class="col-md-7">
                                    <p class="fw-bold text-capitalize">
                                        {{$car->year . ' - ' . $car->brand . ' ' . $car->model . ' ' . $car->color}}</p>
                                    <p class="text-capitalize">
                                        {{ number_format($car->mileage, 0, ',', '.') . ' KM | ' . $car->transmission }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-md-4 mt-1">
                                <p class="fw-medium mb-1">Lokasi Mobil: </p>
                                <p>Pekapuran Jl 1000 RT 06/05 NO 200 SUKAMAJU BARU TAPOS DEPOK</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-submit w-100">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
{{-- end formDp --}}

@push('web-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // Format input jumlah DP
    // const jumlahDPInput = document.getElementById('jumlahDP');

    // jumlahDPInput.addEventListener('input', function (e) {
    //     let value = e.target.value.replace(/[^\d]/g, ''); // Hapus selain angka
    //     if (value) {
    //         // Format number with thousand separator
    //         let formatted = parseInt(value).toLocaleString('id-ID');
    //         e.target.value = 'Rp ' + formatted;
    //     } else {
    //         e.target.value = ''; // kosongkan, biar placeholder "Ketik jumlah DP" muncul lagi
    //     }
    // });

    // Format input amount to Rupiah
    function formatRupiah(angka) {
        let numberString = angka.replace(/\D/g, "");
        let formatted = numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return numberString ? 'Rp ' + formatted : '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputFormatted = document.getElementById('amount_format');
        const inputHidden = document.getElementById('amount');

        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            inputHidden.value = clean;
        });
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
