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
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                {{-- Alert Notifikasi Gagal --}}
                {{-- Tabel mobil dengan fitur DataTables --}}
                <div class="table-responsive">
                    <table id="cars-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Dibuat</th>
                                <th>Mobil</th>
                                <th>Pembeli</th>
                                {{-- <th>Saler</th> --}}
                                <th>Harga</th>
                                <th>Tanggal Terjual</th>
                                <th>Status</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($offerRecords as $offerRecord)
                            <tr>
                                <td>{{ $offerRecord->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($offerRecord->created_at)->translatedFormat('d F Y H:i') }}
                                </td>
                                <td>{{ $offerRecord->offer->brand . ' ' . $offerRecord->offer->model . ' ' . $offerRecord->offer->year }}</a>
                                </td>
                                <td>{{ $offerRecord->buyerOfferRecord->name }}</td>
                                {{-- <td>{{ $offerRecord->salerOfferRecord->name }}</td> --}}
                                <td>Rp. {{ number_format($offerRecord->sale_price, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($offerRecord->sale_date)->translatedFormat('d F Y H:i') }}
                                </td>
                                <td>
                                    @if ($offerRecord->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                    @elseif ($offerRecord->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                    @elseif ($offerRecord->status == 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                    @else
                                    <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    @if ($offerRecord->status == 'completed')
                                    <a href="{{ route('user.transactionofferRecord.createTesti', $offerRecord->id) }}"
                                        class="btn btn-primary btn-sm">Testimoni</a>

                                    @endif
                                </td> --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Data Tidak Tersedia.</td>
                            </tr>
                            @endforelse
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
