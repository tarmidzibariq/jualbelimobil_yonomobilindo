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
            <form id="formDPSubmit" class="row">
                <!-- Kolom kiri: Form Tanggal dan Waktu -->
                <div class="col-lg-7">
                    <div class="card border-0 p-3 shadow rounded-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label fw-medium">Tanggal Janji Temu</label>
                                <input type="date" class="form-control py-2" id="tanggal">
                            </div>
                            <div>
                                <label for="waktu" class="form-label fw-medium">Waktu</label>
                                <input type="time" class="form-control py-2" id="waktu">
                            </div>
                        </div>
                    </div>

                    <!-- Kolom untuk jumlah DP -->
                    <div class="card border-0 p-3 shadow rounded-3 my-5">
                        <div class="card-body">
                            <div>
                                <label for="jumlahDP" class="form-label fw-medium">Masukkan Jumlah DP || Minimal DP Rp
                                    500.000</label>
                                <input type="text" class="form-control py-2 amount-display"
                                    placeholder="Ketik jumlah DP" id="jumlahDP" />
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
                                    <img src="Tangkapan Layar 2025-05-20 pukul 16.42.21.png" alt="" class="img-fluid" />
                                </div>
                                <div class="col-md-7">
                                    <p class="fw-bold">2021 - Toyota AVANZA VELOZ SILVER</p>
                                    <p>50.000 KM | Automatic</p>
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
    const jumlahDPInput = document.getElementById('jumlahDP');

    jumlahDPInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, ''); // Hapus selain angka
        if (value) {
            // Format number with thousand separator
            let formatted = parseInt(value).toLocaleString('id-ID');
            e.target.value = 'Rp ' + formatted;
        } else {
            e.target.value = ''; // kosongkan, biar placeholder "Ketik jumlah DP" muncul lagi
        }
    });

    // Form submission
    document.getElementById('formDPSubmit').addEventListener('submit', function (e) {
        e.preventDefault();

        const tanggal = document.getElementById('tanggal').value;
        const waktu = document.getElementById('waktu').value;
        const jumlahDP = document.getElementById('jumlahDP').value;

        // Validation
        if (!tanggal || !waktu || jumlahDP.trim() === '') {
            alert('Mohon lengkapi semua field yang diperlukan!');
            return;
        }

        // Extract number from formatted DP amount
        const dpAmount = parseInt(jumlahDP.replace(/[^\d]/g, ''));
        if (dpAmount < 500000) {
            alert('Minimal DP adalah Rp 500.000');
            return;
        }

        alert('Form berhasil disubmit!\nTanggal: ' + tanggal + '\nWaktu: ' + waktu + '\nJumlah DP: ' +
            jumlahDP);
    });

</script>
@endpush
@endsection
