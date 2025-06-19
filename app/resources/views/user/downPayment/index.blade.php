@extends('layouts.master')
@section('content')
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Dibuat</th>
                                <th>Mobil</th>
                                <th>Jumlah DP</th>
                                <th>Tanggal Janjian</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($downPayments as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}</td>
                                <td class="text-capitalize">
                                    {{ $item->car->brand . ' ' . $item->car->model . ' ' . $item->car->year }}
                                </td>
                                <td>{{ 'Rp ' . number_format($item->amount , 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->appointment_date)->translatedFormat('d F Y H:i') }}</td>
                                <td>
                                    @if ($item->car->status === 'available')
                                        @switch($item->payment_status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                @break
                                            @case('confirmed')
                                                @if(optional($item->refund)->refund_status === 'refund')
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
                                        
                                    @else
                                        <span class="badge bg-secondary">Mobil Tidak Tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->payment_status == 'pending')
                                    {{-- <a href="#" class="btn btn-sm btn-primary mb-1 pay-now-btn" data-id="{{ $item->id }}">
                                        Bayar Sekarang
                                    </a> --}}
                                    <a href="{{ route('user.downPayment.checkout' , $item->id)}}" class="btn btn-sm btn-primary mb-1" data-id="{{ $item->id }}">
                                        Bayar Sekarang
                                    </a>

                                    @else
                                    <a href="{{ route('user.downPayment.checkout' , $item->id)}}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="card-footer clearfix">
                    <div class="pagination pagination-sm m-0 float-end">
                        {{ $downPayments->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const payButtons = document.querySelectorAll('.pay-now-btn');

        payButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const dpId = this.dataset.id;

                fetch(`/user/payment/${dpId}/token`)    
                    .then(response => response.json())
                    .then(data => {
                        if (data.snapToken) {
                            window.snap.pay(data.snapToken, {
                                onSuccess: function (result) {
                                    alert('Pembayaran berhasil!');
                                    location.reload();
                                },
                                onPending: function (result) {
                                    alert('Menunggu pembayaran!');
                                },
                                onError: function (result) {
                                    alert('Pembayaran gagal!');
                                },
                                onClose: function () {
                                    alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
                                }
                            });
                        } else {
                            alert('Gagal mengambil token pembayaran');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil token pembayaran.');
                    });
            });
        });
    });
</script>
@endpush
