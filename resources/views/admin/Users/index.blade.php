@extends('layouts.master')
@section('content')
<div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">
    <div class="card mb-4">
      {{-- <div class="card-header"><h3 class="card-title">Bordered Table</h3></div> --}}

      <div class="card-body">

        {{-- Alert Notifikasi Sukses --}}
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        {{-- End Alert Notifikasi Sukses --}}

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create</a>
        </div>
        {{-- Form Search --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center mb-3" role="search">
          <div class="col-md-4">
              <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
          </div>
          <div class="col-md-4">
            <select name="role" class="form-select">
              <option value="">All Roles</option>
              <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
          </div>
          <div class="col-md-4">
              <input type="text" name="address" class="form-control" placeholder="Search Address" value="{{ request('address') }}">
          </div>
          <div class="col-12">
              <button type="submit" class="btn btn-success">Search</button>
              <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
          </div>
        </form>
        {{-- End Form Search --}}

        {{-- Table --}}
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">ID</th>
                <th>Created At</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($users as $item)
                <tr class="align-middle">
                  <td>{{ $item->id }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->role }}</td>
                  <td>{{ $item->phone  ?? '-'}}</td>
                  <td>{{ $item->address ?? '-' }}</td>
                  <td>
                    <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center">No users found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- End Table --}}

      </div>

      <div class="card-footer clearfix">
        <div class="pagination pagination-sm m-0 float-end">
          {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
