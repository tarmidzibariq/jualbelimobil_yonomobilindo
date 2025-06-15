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


                {{-- Tabel mobil dengan fitur DataTables --}}
                <div class="table-responsive">
                    <table id="cars-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Create At</th>
                                <th>Car</th>
                                <th>Offer Price</th>
                                <th>Inspection Date</th>
                                {{-- <th>Note</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>

                

            </div>

            
        </div>
    </div>
</div>
@endsection

