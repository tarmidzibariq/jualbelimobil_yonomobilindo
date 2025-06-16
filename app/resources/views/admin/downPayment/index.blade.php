@extends('layouts.master')
@section('content')

<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">

                {{-- Alert Notifikasi Sukses --}}
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form method="GET" action="{{ route('admin.downPayment.index') }}" class="row g-3 mb-4">

                    {{-- Filter Tanggal (Created At) --}}
                    <div class="col-md-4">
                        <label for="date_range" class="form-label">Created At</label>
                        <input type="text" name="date_range" id="date_range" class="form-control" value="{{ request('date_range') }}" placeholder="Pilih rentang tanggal">
                    </div>
                    
                    {{-- Filter Status --}}
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="payment:pending">Pending</option>
                            <option value="payment:confirmed">Confirmed</option>
                            <option value="payment:cancelled">Cancelled</option>
                            <option value="payment:expired">Expired</option>
                            <option value="refund:refund">Refunded</option>
                        </select>
                    </div>

                    {{-- Filter Nama Mobil --}}
                    <div class="col-md-4">
                        <label for="keyword" class="form-label">Nama Mobil</label>
                        <input type="text" class="form-control" name="keyword" id="keyword" value="{{ request('keyword') }}"
                            placeholder="Masukkan nama mobil...">
                    </div>
                    

                    {{-- Tombol Filter --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ route('admin.downPayment.index') }}" class="btn btn-secondary">Reset</a>
                    </div>

                </form>

                {{-- Tabel mobil dengan fitur DataTables --}}
                <div class="table-responsive">
                    <table id="cars-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Created At</th>
                                <th>User</th>
                                <th>Car</th>
                                <th>Amount DP</th>
                                <th>Inspection Date </th>
                                <th>Inspection Time</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($downPayments as $downPayment)
                            <tr>
                                <td>{{$downPayment->id}}</td>
                                <td>{{ \Carbon\Carbon::parse($downPayment->created_at)->translatedFormat('d F Y H:i') }}
                                </td>
                                <td>{{$downPayment->user->name}} </td>
                                <td>{{ $downPayment->car->brand . ' ' . $downPayment->car->model }}</td>
                                <td>Rp. {{ number_format($downPayment->amount, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($downPayment->inspection_date)->translatedFormat('d F Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($downPayment->inspection_time)->translatedFormat('H:i') .' WIB' }}
                                </td>
                                <td>
                                    @switch($downPayment->payment_status)
                                    @case('pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @break
                                    @case('confirmed')
                                        @if(optional($downPayment->refund)->refund_status === 'refund')
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
                                <td>
                                    {{-- Tombol untuk membuka modal detail mobil --}}
                                    <button type="button" class="btn btn-sm btn-info btn-show-detail"
                                        data-id="{{ $downPayment->id }}" data-bs-toggle="modal"
                                        data-bs-target="#downPaymentModal">
                                        Show
                                    </button>
                                    {{-- Tombol untuk edit down payment --}}
                                    @if ( $downPayment->payment_status === 'confirmed' && $downPayment->refund_id === null)
                                        <a href="{{ route('admin.downPayment.addRefund', $downPayment->id) }}"
                                            class="btn btn-sm btn-secondary">
                                            Refund
                                        </a>
                                    @elseif ($downPayment->payment_status === 'confirmed' && $downPayment->refund_id !== null)
                                        <a href="{{ route('admin.downPayment.editRefund', $downPayment->id) }}"
                                            class="btn btn-sm btn-secondary">
                                            Edit Refund
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No down payments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Modal kosong, akan diisi konten AJAX -->
                <div class="modal fade" id="downPaymentModal" tabindex="-1" aria-labelledby="downPaymentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="downPaymentModalContent">
                            <!-- Konten modal akan di-load via AJAX -->
                            <div class="modal-body text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pagination --}}
            {{-- <div class="card-footer clearfix">
                <div class="pagination pagination-sm m-0 float-end">
                    {{ $cars->appends(request()->query())->links('pagination::bootstrap-5') }}

        </div>
    </div> --}}
</div>
</div>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>
<script>
    flatpickr("#date_range", {
        mode: "range",
        dateFormat: "Y-m-d",
        defaultDate: @json(explode(' to ', request('date_range')))
    });

    $(document).ready(function () {

        // ===============================
        // 1. Show detail downPayment ke dalam modal
        // ===============================
        $('.btn-show-detail').on('click', function () {
            let downPaymentId = $(this).data('id');
            let modalContent = $('#downPaymentModalContent');

            modalContent.html(`
          <div class="modal-body text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        `);

            $.ajax({
                url: `/admin/downPayment/${downPaymentId}`, // Show route: menampilkan detail mobil
                method: 'GET',
                success: function (response) {
                    modalContent.html(response); // Load ke dalam modal
                },
                error: function () {
                    modalContent.html(
                        '<div class="modal-body text-danger">Failed to load data.</div>'
                    );
                }
            });
        });


    });

</script>
@endpush
@endsection
