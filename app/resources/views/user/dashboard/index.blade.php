@extends('layouts.master')
@section('content')
@push('styles')
    <style>
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
            transform: translateY(-2px);
            transition: all 0.3s;
        }
    </style>
@endpush
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4 mb-3">
                <div class="bg-light border rounded shadow-sm p-3 d-flex align-items-center hover-shadow position-relative">
                    <div class="bg-success text-white rounded d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-cart-fill fs-4"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="fw-bold text-dark">Transaksi Pembelian Mobil</div>
                        <div class="text-muted">Total: {{$salesRecord}}</div>
                            <a href="{{ route('user.transactionSalesRecord.index') }}" class="text-decoration-none">
                                <small class="text-success d-block mt-1">More info <i class="bi bi-arrow-right"></i></small>
                            </a>
                        </div>
                    </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 mb-3">
                <div class="bg-light border rounded shadow-sm p-3 d-flex align-items-center hover-shadow position-relative">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-cart-fill fs-4"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="fw-bold text-dark">Transaksi Penjualan Mobil</div>
                        <div class="text-muted">Total: {{ $offerRecord }}</div>
                            <a href="{{ route('user.transactionOfferRecord.index') }}" class="text-decoration-none">
                                <small class="text-primary d-block mt-1">More info <i class="bi bi-arrow-right"></i></small>
                            </a>
                        </div>
                    </div>
            </div>

            {{-- Pembayaran DP Pending --}}
            <div class="col-12 mb-4">
                @if ($downPayment && $downPayment->payment_status === 'pending')
                <div class="card  card-warning collapsed-card">
                    <div class="card-header" data-lte-toggle="card-collapse">
                        <h3 class="card-title">{{ '#'. $downPayment->id ?? '-'}} Down Payment Pending</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID Pembayaran</th>
                                <td>{{ '#'. $downPayment->id ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ \Carbon\Carbon::parse($downPayment->created_at)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Mobil</th>
                                <td class="text-uppercase">#{{ $downPayment->car_id }}
                                    {{ $downPayment->car->brand  . ' ' . $downPayment->car->model . ' ' . $downPayment->car->year . ' '. $downPayment->car->color ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Janji</th>
                                <td>{{ \Carbon\Carbon::parse($downPayment->appointment_date)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jam Janji</th>
                                <td>{{\Carbon\Carbon::parse($downPayment->appointment_date)->format('H:i') . ' WIB'  }}
                                </td>
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
                                <td>{{ $downPayment->order_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Pembayaran</th>
                                <td>Rp {{ number_format($downPayment->amount, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        {{-- Tombol bayar --}}
                        @if($downPayment->payment_status == 'pending' && $downPayment->car->status == "available")
                        <div class="mt-4">
                            <a href="{{route('user.downPayment.checkout', $downPayment->id)}}"
                                class="btn btn-success mt-4">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </a>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                @endif
            </div>

            {{-- Permintaan Penjualan Mobil Accepted --}}
            <div class="col-12 mb-4">
                <div class="card ">
                    <div class="card-header border-0">
                    <h3 class="card-title">Permintaan Penjualan Mobil</h3>
                    {{-- <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-download"></i> </a>
                        <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-list"></i> </a>
                    </div> --}}
                    </div>
                    <div class="card-body table-responsive p-0">
                    <table class="table table-striped align-middle">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mobil</th>
                            <th>Penawaran Harga</th>
                            <th>Tanggal Janjian</th>
                            <th>Detail</th>
                        </tr>
                        </thead>
                            <tbody>
                                @forelse ($offers as $offer)
                                    <tr>
                                        <td># {{$offer->id}}</td>
                                        <td>
                                            {{ $offer->brand }} {{ $offer->model }} {{ $offer->year }}
                                            @switch($offer->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                    @break
                                                @case('accepted')
                                                    <span class="badge bg-success">Accepted</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td>Rp {{ number_format($offer->offered_price, 0, ',', '.') }}</td>
                                        <td>
                                            {{ $offer->inspection_date ? \Carbon\Carbon::parse($offer->inspection_date)->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('user.offer.show', $offer->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
