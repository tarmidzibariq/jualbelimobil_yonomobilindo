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

                {{-- Tombol Create mobil baru --}}
                {{-- <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">Create</a>
                </div> --}}

                {{-- Form Filter pencarian berdasarkan Brand, Sale Type, dan Status --}}
                <form method="GET" action="{{ route('admin.offer.index') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="date_range" class="form-label">Created At</label>
                        <input type="text" name="date_range" id="date_range" class="form-control" value="{{ request('date_range') }}" placeholder="Pilih rentang tanggal">
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="">-- All Status --</option>
                            @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Filter Nama Mobil (Brand/Model) --}}
                    <div class="col-md-4">
                        <label for="keyword" class="form-label">Car Name</label>
                        <input type="text" name="keyword" id="keyword" class="form-control"
                            value="{{ request('keyword') }}" placeholder="Search brand/model...">
                    </div>

                    {{-- Tombol Submit Filter dan Reset --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                {{-- Tabel mobil dengan fitur DataTables --}}
                <div class="table-responsive">
                    <table id="cars-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Create At</th>
                                <th>User</th>
                                <th>Car</th>
                                <th>Offer Price</th>
                                <th>Inspection Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($offers as $offer)
                            <tr>
                                <td>{{ $offer->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($offer->created_at)->translatedFormat('d F Y H:i') }}</td>
                                <td>{{$offer->user->name}}</td>
                                <td>{{ $offer->brand . ' ' . $offer->model }}</td>
                                <td>{{ 'Rp ' . number_format($offer->offered_price, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($offer->inspection_date)->translatedFormat('d F Y H:i') }}</td>
                                <td>
                                    @php
                                        $status = $offer->status;
                                        $badgeClass = match($status) {
                                            'pending' => 'bg-warning',
                                            'accepted' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} status-label-{{ $offer->id }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1 btn-edit-status"
                                        data-id="{{ $offer->id }}" data-status="{{ $offer->status }}"
                                        data-bs-toggle="modal" data-bs-target="#statusModal">
                                        Update Status
                                    </button>
                                </td>
                                <td>
                                    {{-- Optional action --}}
                                    <a href="{{ route('admin.offer.show', $offer->id) }}" class="btn btn-sm btn-info">
                                        Show
                                </td>
                            </tr>

                            {{-- Jika tidak ada data mobil --}}
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No Offers Found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Modal kosong yang akan diisi via AJAX --}}
                <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" id="statusModalContent">
                            <div class="modal-body text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            
                {{-- Pagination --}}
                <div class="card-footer clearfix">
                    <div class="pagination pagination-sm m-0 float-end">
                        {{ $offers->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

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
        
        // Load form update status ke dalam modal
        $(document).on('click', '.btn-edit-status', function () {
            const offerId = $(this).data('id');
            const modalContent = $('#statusModalContent');

            modalContent.html(`
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            $.ajax({
                url: `/admin/offer/${offerId}/edit-status`,
                method: 'GET',
                success: function (html) {
                    modalContent.html(html);
                },
                error: function () {
                    modalContent.html(
                        '<div class="modal-body text-danger">Gagal memuat form status.</div>'
                    );
                }
            });
        });

        // Submit form update status
        $(document).on('submit', '#form-update-status', function (e) {
            e.preventDefault();

            const offerId = $('#modal-offer-id').val();
            const newStatus = $('#new-status').val();

            $.ajax({
                url: `/admin/offer/${offerId}/update-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function (res) {
                    $('#statusModal').modal('hide');

                    const badge = $(`.status-label-${offerId}`);
                    badge.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                    badge.removeClass('bg-warning bg-success bg-danger bg-secondary')
                         .addClass(getBadgeClass(newStatus));

                    alert(res.message); 
                },
                error: function (xhr) {
                    console.error('Update failed:', xhr.status, xhr.responseText);
                    alert('Failed to update status');
                }
            });

            function getBadgeClass(status) {
                switch (status) {
                    case 'pending': return 'bg-warning';
                    case 'accepted': return 'bg-success';
                    case 'rejected': return 'bg-danger';
                    default: return 'bg-secondary';
                }
            }
        });
    });
</script>
@endpush
