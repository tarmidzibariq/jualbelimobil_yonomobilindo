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

        {{-- Tombol Create --}}
        <div class="d-flex justify-content-between mb-3">
          <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">Create</a>
        </div>

        {{-- Tabel Mobil --}}
        <table class="table table-bordered">
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
            @foreach ($cars as $car)
            <tr>
              <td>{{ $car->id }}</td>
              <td>{{ $car->brand }}</td>
              <td>{{ $car->model }}</td>
              <td>{{ number_format($car->price, 0, ',', '.') }}</td>
              <td>{{ ucfirst($car->sale_type) }}</td>
              <td>{{ ucfirst($car->status) }}</td>
              <td>
                <!-- Tombol Show pakai Modal -->
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#carModal{{ $car->id }}">
                  Show
                </button>

                <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
              </td>
            </tr>

            <!-- Modal untuk Show -->
            <div class="modal fade" id="carModal{{ $car->id }}" tabindex="-1" aria-labelledby="carModalLabel{{ $car->id }}" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="carModalLabel{{ $car->id }}">Car Detail: {{ $car->brand }} {{ $car->model }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-bordered">
                      <tr><th>ID</th><td>{{ $car->id }}</td></tr>
                      <tr><th>User ID</th><td>{{ $car->user_id }}</td></tr>
                      <tr><th>Brand</th><td>{{ $car->brand }}</td></tr>
                      <tr><th>Model</th><td>{{ $car->model }}</td></tr>
                      <tr><th>Year</th><td>{{ $car->year }}</td></tr>
                      <tr><th>Price</th><td>{{ number_format($car->price, 0, ',', '.') }}</td></tr>
                      <tr><th>Transmission</th><td>{{ $car->transmission }}</td></tr>
                      <tr><th>Description</th><td>{{ $car->description }}</td></tr>
                      <tr><th>Service History</th><td>{{ $car->sercve_history }}</td></tr>
                      <tr><th>Fuel Type</th><td>{{ $car->fuel_type }}</td></tr>
                      <tr><th>Mileage</th><td>{{ $car->mileage }}</td></tr>
                      <tr><th>Sale Type</th><td>{{ $car->sale_type }}</td></tr>
                      <tr><th>Status</th><td>{{ $car->status }}</td></tr>
                      <tr><th>Created At</th><td>{{ $car->created_at }}</td></tr>
                      <tr><th>Updated At</th><td>{{ $car->updated_at }}</td></tr>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
@endsection
