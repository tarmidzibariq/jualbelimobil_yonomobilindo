@extends('layouts.master')
@section('content')
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Dibuat</th>
                                <th>Mobil</th>
                                <th>Penawaran Harga</th>
                                <th>Tanggal Janjian</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($offers as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}</td>
                                <td class="text-capitalize">
                                    {{ $item->brand . ' ' . $item->model . ' ' . $item->year }}
                                </td>
                                <td>{{ 'Rp ' . number_format($item->offered_price, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->appointment_date)->translatedFormat('d F Y H:i T') }}</td>
                                <td>
                                    @switch($item->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @break
                                        @case('accepted')
                                            <span class="badge bg-success">Accepted</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{route('user.offer.show',$item->id)}}" class="btn btn-sm btn-info">Detail</a>
                                   
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

