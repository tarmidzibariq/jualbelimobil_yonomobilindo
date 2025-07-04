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
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">Create</a>
                </div>

                {{-- Form Filter pencarian berdasarkan Brand, Sale Type, dan Status --}}
                <form method="GET" action="{{ route('admin.cars.index') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="brand" class="form-label">Brand</label>
                        <select class="form-select" name="brand" id="brand">
                            <option value="">-- All Brands --</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                {{ $brand }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="sale_type" class="form-label">Sale Type</label>
                        <select class="form-select" name="sale_type" id="sale_type">
                            <option value="">-- All Sale Types --</option>
                            @foreach ($sale_types as $key => $label)
                            <option value="{{ $key }}" {{ request('sale_type') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="">-- All Statuses --</option>
                            @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Submit Filter dan Reset --}}
                    <div class="col-12">
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Reset</a>
                        <button type="submit" class="btn btn-success">Filter</button>
                    </div>
                </form>

                {{-- Tabel mobil dengan fitur DataTables --}}
                <div class="table-responsive">
                    <table id="cars-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Price</th>
                                <th>Sale Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cars as $car)
                            <tr>
                                <td>{{ $car->id }}</td>
                                <td>{{ $car->brand }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ number_format($car->price, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($car->sale_type) }}</td>
                                <td>
                                    <!-- Label status saat ini -->
                                    @php
                                    $status = $car->status;
                                    $badgeClass = match($status) {
                                    'available' => 'bg-success',
                                    'pending_check' => 'bg-warning text-dark',
                                    'sold' => 'bg-danger',
                                    'under_review' => 'bg-info text-dark',
                                    default => 'bg-secondary',
                                    };
                                    @endphp

                                    <span class="badge {{ $badgeClass }} status-label status-label-{{ $car->id }}"
                                        data-id="{{ $car->id }}"
                                        data-status="{{ $status }}">
                                        {{ ucfirst($status) }}
                                    </span>

                                    {{-- Jika status adalah 'pending_check', tampilkan tombol update status --}}

                                    <!-- Tombol untuk membuka modal update status -->
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1 btn-edit-status"
                                        data-id="{{ $car->id }}" {{-- ID mobil --}} data-status="{{ $car->status }}"
                                        {{-- Status saat ini --}} data-bs-toggle="modal" data-bs-target="#statusModal">
                                        Update Status
                                    </button>
                                </td>
                                <td>
                                    {{-- Tombol untuk membuka modal detail mobil --}}
                                    <button type="button" class="btn btn-sm btn-info btn-show-detail"
                                        data-id="{{ $car->id }}" data-bs-toggle="modal" data-bs-target="#carModal">
                                        Show
                                    </button>
                                    {{-- Tombol edit --}}
                                    <a href="{{ route('admin.cars.edit', $car->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    {{-- Form untuk delete dengan konfirmasi --}}
                                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No Cars Found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal kosong untuk show, akan diisi konten AJAX -->
                <div class="modal fade" id="carModal" tabindex="-1" aria-labelledby="carModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="carModalContent">
                            <!-- Konten modal akan di-load via AJAX -->
                            <div class="modal-body text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal update status (kosong, isi via AJAX) -->
                <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                    aria-hidden="true">
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

            </div>

            {{-- Pagination --}}
            <div class="card-footer clearfix">
                <div class="pagination pagination-sm m-0 float-end">
                    {{ $cars->appends(request()->query())->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        // ===============================
        // 1. Show detail mobil ke dalam modal
        // ===============================
        $('.btn-show-detail').on('click', function () {
            let carId = $(this).data('id');
            let modalContent = $('#carModalContent');

            modalContent.html(`
          <div class="modal-body text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        `);

            $.ajax({
                url: `/admin/cars/${carId}`, // Show route: menampilkan detail mobil
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

        // ===============================
        // 2. Load form update status via AJAX modal
        // ===============================
        $(document).on('click', '.btn-edit-status', function () {
            const carId = $(this).data('id');
            const modalContent = $('#statusModalContent');

            modalContent.html(`
          <div class="modal-body text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        `);

            $.ajax({
                url: `/admin/cars/${carId}/edit-status`, // Route untuk ambil form partial
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

        // ===============================
        // 3. Submit update status via AJAX
        // ===============================
        $(document).on('submit', '#form-update-status', function (e) {
            e.preventDefault();

            const carId = $('#modal-car-id').val(); // dari input hidden
            const newStatus = $('#new-status').val();

            $.ajax({
                url: `/admin/cars/${carId}/update-status`, // Route untuk update status
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function (res) {
                    $('#statusModal').modal('hide');

                    // Update tampilan badge status di table
                    const badge = $(`.status-label-${carId}`);
                    badge.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

                    // Bersihkan class lama dan tambahkan class baru
                    badge.removeClass('bg-success bg-warning text-dark bg-danger bg-info text-dark bg-secondary');
                    badge.addClass(getBadgeClass(newStatus));

                    // alert('Status updated successfully!');
                },

                error: function (xhr) {
                    console.error('Update failed:', xhr.status, xhr.responseText);
                    alert('Failed to update status');
                }
            });

            function getBadgeClass(status) {
                switch (status) {
                    case 'available': return 'bg-success';
                    case 'pending_check': return 'bg-warning text-dark';
                    case 'sold': return 'bg-danger';
                    case 'under_review': return 'bg-info text-dark';
                    default: return 'bg-secondary';
                }
            }

        });

    });

</script>


@endpush
