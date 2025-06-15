@extends('layouts.master')
@section('content')
<div class="app-content">
    <div class="container-fluid">
         @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="fw-bold mb-4">Detail Penjualan Mobil {{ $offer->brand  . ' ' . $offer->model . ' ' . $offer->year ?? '-' }} </h3>

                <table class="table table-bordered">
                    <tr>
                        <th>ID Pembayaran</th>
                        <td>{{ '#'. $offer->id ?? '-'}}</td>
                    </tr>
                    <tr>
                        <th>Status Penjualan</th>
                        <td>
                            <span class="badge 
                                @if($offer->status == 'pending') bg-warning 
                                @elseif($offer->status == 'accepted') bg-success 
                                @elseif($offer->status == 'rejected') bg-danger 
                                @endif">
                                {{ ucfirst($offer->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Nama Pengguna</th>
                        <td>{{ $offer->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $offer->user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ $offer->user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Mobil</th>
                        <td>{{ $offer->brand  . ' ' . $offer->model . ' ' . $offer->year ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Janji</th>
                        <td>{{ \Carbon\Carbon::parse($offer->appointment_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jam Janji</th>
                        <td>{{ \Carbon\Carbon::parse($offer->appointment_date)->format('H:i T') }}</td>
                    </tr>
                    <tr>
                        <th>Penawaran Harga Mobil</th>
                        <td>Rp {{ number_format($offer->offered_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Inspeksi</th>
                        <td>
                            @if($offer->status === 'accepted' && $offer->location_inspection === 'Datang Ke Showroom')
                            Datang Ke Showroom<br>
                            Lokasi: Pekapuran Jl 1000 RT 06/05 NO 200 SUKAMAJU BARU TAPOS, DEPOK<br>
                            Kontak Admin: 081220745317
                            @elseif($offer->location_inspection === 'Rumah')
                            Rumah<br>
                            Lokasi: {{ Auth::user()->address ?? 'Alamat tidak tersedia' }}
                            <br>
                            <button class="btn btn-sm btn-info mt-2" data-bs-toggle="modal" data-bs-target="#alamatModal">
                                Lengkapi Alamat
                            </button>
                            @else
                            {{ $offer->location_inspection }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        @if ($offer->note != null)
                            <th>Catatan Showroom</th>
                            <td>{{$offer->note}}</td>
                        @endif
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lengkapi Alamat -->
<div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="alamatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('user.updateAdress', $offer->user->id) }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alamatModalLabel">Lengkapi Alamat Anda</h5><small> (bisa tambahkan sharelok)</small>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap <small> (bisa tambahkan sharelok)</small></label>
                    <textarea name="address" class="form-control" rows="3" required>{{ old('address', Auth::user()->address) }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection
