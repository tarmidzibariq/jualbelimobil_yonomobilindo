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
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($salesRecords as $salesRecord)
                            <tr>
                                <td>{{ $salesRecord->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($salesRecord->created_at)->translatedFormat('d F Y H:i') }}</td>
                                <td><a href="" class="btn-show-detail" data-id="{{ $salesRecord->car->id }}" data-bs-toggle="modal" data-bs-target="#carModal">{{ $salesRecord->car->brand . ' ' . $salesRecord->car->model . ' ' . $salesRecord->car->year }}</a></td>
                                <td>{{ $salesRecord->saler->name }}</td>
                                <td>{{ $salesRecord->buyer->name }}</td>
                                <td>Rp. {{ number_format($salesRecord->sale_price, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($salesRecord->sale_date)->translatedFormat('d F Y H:i') }}</td>
                                <td>
                                    @if ($salesRecord->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($salesRecord->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif ($salesRecord->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No sales records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            
                {{-- Pagination --}}
                <div class="card-footer clearfix">
                    <div class="pagination pagination-sm m-0 float-end">
                        {{ $salesRecords->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

