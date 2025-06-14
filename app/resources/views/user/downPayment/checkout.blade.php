{{-- @if(isset($snapToken))
<script>
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            window.location.href = "{{ route('user.dashboard') }}";
        }
    });
</script>
@endif --}}

@extends('layouts.master')
@section('content')
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="fw-bold mb-4">Detail Pembayaran</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>ID Pembayaran</th>
                        <td>{{ '#'. $downPayments->id ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran DP</th>
                        <td>
                            <span class="badge 
                                @if($downPayments->payment_status == 'pending') bg-warning 
                                @elseif($downPayments->payment_status == 'confirmed') bg-success 
                                @elseif($downPayments->payment_status == 'cancelled') bg-danger 
                                @endif">
                                {{ ucfirst($downPayments->payment_status) }}
                            </span>
                        </td>
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
                        <th>Mobil</th>
                        <td>{{ $downPayments->car->brand  . ' ' . $downPayments->car->model . ' ' . $downPayments->car->year ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Janji</th>
                        <td>{{ \Carbon\Carbon::parse($downPayments->appointment_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jam Janji</th>
                        <td>{{ \Carbon\Carbon::parse($downPayments->appointment_date)->format('H:i T') }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pembayaran</th>
                        <td>Rp {{ number_format($downPayments->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pembayaran</th>
                        <td>{{ $downPayments->payment_date ? \Carbon\Carbon::parse($downPayments->payment_date)->format('d M Y H:i') : '-' }}</td>
                    </tr>
                    {{-- <tr>
                        <th>Bukti Pembayaran</th>
                        <td>
                            @if ($downPayments->payment_proof)
                                <a href="{{ asset('storage/' . $downPayments->payment_proof) }}" target="_blank">Lihat Bukti</a>
                            @else
                                Belum Ada
                            @endif
                        </td>
                    </tr> --}}
                </table>

                @if($downPayments->payment_status == 'pending' && isset($snapToken))
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
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("Pembayaran berhasil!");
                window.location.href = "{{ route('user.dashboard') }}";
            },
            onPending: function(result){
                alert("Menunggu pembayaran.");
                window.location.href = "{{ route('user.dashboard') }}";
            },
            onError: function(result){
                alert("Pembayaran gagal.");
                window.location.href = "{{ route('user.dashboard') }}";
            },
            onClose: function(){
                alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
            }
        });
    });
</script>
@endpush
@endsection
