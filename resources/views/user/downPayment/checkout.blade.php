
@extends('layouts.master')
@section('content')
<div class="app-content">
    <div class="container-fluid">
        {{-- Alert Notifikasi Sukses --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        {{-- Alert Notifikasi Error --}}
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="fw-bold mb-4">Detail Pembayaran</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>ID Pembayaran</th>
                        <td>{{ '#'. $downPayments->id ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ \Carbon\Carbon::parse($downPayments->created_at)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Mobil</th>
                        <td class="text-uppercase">#{{ $downPayments->car_id }} {{ $downPayments->car->brand  . ' ' . $downPayments->car->model . ' ' . $downPayments->car->year . ' '. $downPayments->car->color ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pengguna</th>
                        <td>{{ $downPayments->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $downPayments->user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ $downPayments->user->phone ?? '-' }}</td>
                    </tr>
                    
                    <tr>
                        <th>Tanggal Janji</th>
                        <td>{{ \Carbon\Carbon::parse($downPayments->appointment_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jam Janji</th>
                        <td>{{\Carbon\Carbon::parse($downPayments->appointment_date)->format('H:i') . ' WIB'  }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Showroom</th>
                        <td>Lokasi: Pekapuran Jl 1000 RT 06/05 NO 200 SUKAMAJU BARU TAPOS, DEPOK<br>
                            Kontak Showroom: 081220745317</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-muted">Informasi Pembayaran</th>
                    </tr>
                     <tr>
                        <th>Order ID</th>
                        <td>{{ $downPayments->order_id ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran DP</th>
                        <td>
                            @switch($downPayments->payment_status)
                                @case('pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @break
                                @case('confirmed')
                                    @if(optional($downPayments->refund)->refund_status === 'refund')
                                        <span class="badge bg-success">Confirmed</span> | <span class="badge bg-secondary">Refund</span>
                                    @else
                                        <span class="badge bg-success">Confirmed</span>
                                    @endif
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                    @break
                                @case('expired')
                                    <span class="badge bg-danger">Expired</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ ucfirst($item->payment_status) }}</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td>{{ $downPayments->payment_method ?? 'Belum Dibayar'}}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pembayaran</th>
                        <td>Rp {{ number_format($downPayments->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pembayaran</th>
                        <td>{{ $downPayments->payment_date ? \Carbon\Carbon::parse($downPayments->payment_date)->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    @if ($downPayments->payment_status == 'confirmed')
                    
                        
                    @endif

                    @if ($downPayments->refund_id !== null && $downPayments->payment_status === 'confirmed')
                        <tr>
                            <th colspan="2" class="text-muted">Informasi Refund</th>
                        </tr>
                        <tr>
                            <th>No Rekening Refund</th>
                            <td>{{ $downPayments->refund ? $downPayments->refund->no_rekening_refund : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bukti Pembayaran Refund</th>
                            <td>
                                @if ($downPayments->refund && $downPayments->refund->refund_payment_proof)
                                <img src="{{ asset('storage/refund/' . $downPayments->refund->refund_payment_proof) }}"
                                    alt="Bukti Pembayaran Refund" class="img-thumbnail" style="max-height: 200px; object-fit: contain;">
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        {{-- <tr>
                            
                            <th>Status Refund</th>
                            <td>
                                @if ($downPayments->refund)
                                @switch($downPayments->refund->refund_status)
                                @case('refund')
                                <span class="badge bg-danger">Refund</span>
                                @break
                                @case('no_refund')
                                <span class="badge bg-danger">No Refund</span>
                                @break
                                @default
                                <span class="badge bg-secondary">{{ ucfirst($downPayments->refund->status) }}</span>
                                @endswitch
                                @else
                                -
                                @endif
                            </td>
                        </tr> --}}
                        @endif
                </table>

                {{-- Tombol bayar --}}
                @if($downPayments->payment_status == 'pending' && $downPayments->car->status == "available")
                <div class="mt-4">
                    <button id="pay-button" class="btn btn-success mt-4">
                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                    </button>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">

    document.getElementById('pay-button')?.addEventListener('click', function () {
        fetch(`/api/check-midtrans-status/{{ $downPayments->id }}`)
        .then(response => response.json())
                    .then(data => {
                        console.log("Cek status:", data.status);
                        if (data.status == "under_review" || data.status == "sold" || data.status == "pending_check") {
                            alert("Mobil tidak tersedia")
                            window.location = "{{ route('user.downPayment.index') }}"
                        }else if (data.status === 'confirmed' || data.status === 'cancelled') {
                            window.location.href = "{{ route('user.downPayment.changeStatus', $downPayments->id) }}";
                        }else if (data.status == "error") {
                            snap.pay(data.snap_token, {
                                onSuccess: function(result){
                                    // alert("Pembayaran berhasil!");
                                    window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                                },
                                onPending: function(result){
                                    // alert("Menunggu pembayaran.");
                                    window.location.href = "{{ route('user.downPayment.checkout' , $downPayments->id) }}";
                                },
                                onError: function(result){
                                    // alert("Pembayaran gagal.");
                                    window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                                },
                                onClose: function(){
                                    alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
                                },
                            });
                        }
                    })
                    .catch(error => {
                        snap.pay('{{ $snapToken }}', {
                            onSuccess: function(result){
                                // alert("Pembayaran berhasil!");
                                window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                            },
                            onPending: function(result){
                                // alert("Menunggu pembayaran.");
                                window.location.href = "{{ route('user.downPayment.checkout' , $downPayments->id) }}";
                            },
                            onError: function(result){
                                // alert("Pembayaran gagal.");
                                window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                            },
                            onClose: function(){
                                alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
                            },
                        });
                    });
    });
</script>
{{-- <script type="text/javascript">

    document.getElementById('pay-button')?.addEventListener('click', function () {
        fetch(`/api/check-midtrans-status/{{ $downPayments->id }}`)
            .then(response => response.json())
            .then(data => {
                console.log("Cek status:", data.status);

                if (data.status === "under_review" || data.status === "sold" || data.status === "pending_check") {
                    alert("Mobil tidak tersedia");
                    window.location = "{{ route('user.downPayment.index') }}";
                    return;
                }

                if (data.status === "confirmed" || data.status === "cancelled" || data.status === "expired") {
                    window.location.href = "{{ route('user.downPayment.changeStatus', $downPayments->id) }}";
                    return;
                }

                if (data.status === "pending") {
                    // Gunakan snap_token lama
                    snap.pay(data.snap_token, {
                        onSuccess: function (result) {
                            window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                        },
                        onPending: function (result) {
                            window.location.href = "{{ route('user.downPayment.checkout' , $downPayments->id) }}";
                        },
                        onError: function (result) {
                            window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                        },
                        onClose: function () {
                            alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
                        }
                    });
                    return;
                }

                if (data.status === "error") {
                    // Status error → buat Snap baru
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function (result) {
                            window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                        },
                        onPending: function (result) {
                            window.location.href = "{{ route('user.downPayment.checkout' , $downPayments->id) }}";
                        },
                        onError: function (result) {
                            window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                        },
                        onClose: function () {
                            alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
                        }
                    });
                    return;
                }

                // Fallback → jika status tidak diketahui
                alert("Terjadi kesalahan. Silakan coba lagi.");
                window.location.href = "{{ route('user.downPayment.index') }}";

            })
            .catch(error => {
                console.error(error);
                // Gagal panggil API → jalankan Snap baru
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function (result) {
                        window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                    },
                    onPending: function (result) {
                        window.location.href = "{{ route('user.downPayment.checkout' , $downPayments->id) }}";
                    },
                    onError: function (result) {
                        window.location.href = "{{ route('user.downPayment.changeStatus' , $downPayments->id) }}";
                    },
                    onClose: function () {
                        alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
                    }
                });
            });
    });

</script> --}}


@endpush
@endsection
