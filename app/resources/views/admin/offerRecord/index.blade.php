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
                    <a href="{{ route('admin.offerRecord.create') }}" class="btn btn-primary">Create</a>
                </div>

                

                {{-- Tabel mobil dengan fitur DataTables --}}
                <div class="table-responsive">
                    <table id="cars-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Create At</th>
                                <th>Car</th>
                                <th>Saler</th>
                                <th>Buyer</th>
                                <th>Sale Price</th>
                                <th>Sale Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offerRecords as $offerRecord)
                            <tr>
                                <td>{{ $offerRecord->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($offerRecord->created_at)->translatedFormat('d F Y H:i') }}</td>
                                <td><a href="{{route('admin.offer.show',$offerRecord->offer->id)}}" >{{ $offerRecord->offer->brand . ' ' . $offerRecord->offer->model . ' ' . $offerRecord->offer->year }}</a></td>
                                <td>{{ $offerRecord->salerOfferRecord->name }}</td>
                                <td>{{ $offerRecord->buyerOfferRecord->name }}</td>
                                <td>Rp. {{ number_format($offerRecord->sale_price, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($offerRecord->sale_date)->translatedFormat('d F Y') }}</td>
                                <td>
                                    {{-- <a href="{{ route('admin.offerRecord.show', $offerRecord) }}" class="btn btn-info btn-sm">Show</a> --}}
                                    {{-- <a href="{{ route('admin.offerRecord.edit', $offerRecord) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                                    {{-- <form action="{{ route('admin.offerRecord.destroy', $offerRecord) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                    </form> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                {{-- Pagination --}}
                <div class="card-footer clearfix">
                    <div class="pagination pagination-sm m-0 float-end">
                        {{ $offerRecords->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

