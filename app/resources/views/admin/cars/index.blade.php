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
                                <td>{{ ucfirst($car->status) }}</td>
                                <td>
                                    {{-- Tombol untuk membuka modal detail mobil --}}
                                    <button type="button" class="btn btn-sm btn-info btn-show-detail" 
                                      data-id="{{ $car->id }}" data-bs-toggle="modal" data-bs-target="#carModal">
                                      Show
                                    </button>
                                    {{-- Tombol edit --}}
                                    <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-warning">Edit</a>
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
                                <td colspan="7" class="text-center">No users found.</td>
                              </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal kosong, akan diisi konten AJAX -->
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
  $(document).ready(function() {
    $('.btn-show-detail').on('click', function() {
      let carId = $(this).data('id');
      let modalContent = $('#carModalContent');
  
      // Tampilkan loading spinner saat AJAX request
      modalContent.html(`
        <div class="modal-body text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      `);
  
      $.ajax({
        url: `/admin/cars/${carId}`, // route show detail mobil, harus mengembalikan partial view
        method: 'GET',
        success: function(response) {
          modalContent.html(response);
        },
        error: function() {
          modalContent.html('<div class="modal-body"><p class="text-danger">Failed to load data.</p></div>');
        }
      });
    });
  });
</script>
  
@endpush

