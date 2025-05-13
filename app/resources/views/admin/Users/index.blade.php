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

        {{-- Form Search --}}
        <div class="d-flex justify-content-between mb-3">
          <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create</a>
          <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex" role="search">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by name or email" value="{{ request('search') }}">
            <select name="role" class="form-select me-2">
              <option value="">All Roles</option>
              <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
            <button type="submit" class="btn btn-secondary">Search</button>
          </form>
        </div>
        {{-- End Form Search --}}

        {{-- Table --}}
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 10px">ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $item)
              <tr class="align-middle">
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->role }}</td>
                <td>{{ $item->created_at }}</td>
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
                <td colspan="5" class="text-center">No users found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
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
