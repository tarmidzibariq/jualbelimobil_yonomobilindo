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
                            @php
                                $status = $offer->status;
                                $badgeClass = match($status) {
                                    'pending' => 'bg-warning',
                                    'accepted' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} status-label-{{ $offer->id }}">
                                {{ ucfirst($status) }}
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-1 btn-edit-status"
                                data-id="{{ $offer->id }}" data-status="{{ $offer->status }}"
                                data-bs-toggle="modal" data-bs-target="#statusModal">
                                Update Status
                            </button>
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
                        <th>Penawaran Harga Mobil</th>
                        <td>Rp {{ number_format($offer->offered_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Janji</th>
                        <td>{{ \Carbon\Carbon::parse($offer->inspection_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jam Janji</th>
                        <td>{{ \Carbon\Carbon::parse($offer->inspection_date)->format('H:i T') }}</td>
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
                            {{-- <button class="btn btn-sm btn-info mt-2" data-bs-toggle="modal" data-bs-target="#updateStatus">
                                Lengkapi Alamat
                            </button> --}}
                            @else
                            {{ $offer->location_inspection }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Catatan Showroom</th>
                        <td>
                            @if($offer->status === 'accepted' && $offer->note === null)
                            <span class="text-danger">Catatan belum diisi</span>
                            @endif
                            {{ $offer->note  }}
                            <br>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#catatanModal">
                                Tambahkan Catatan
                            </button>
                        </td>
                    </tr>

                </table>
            </div>
            {{-- Modal kosong yang akan diisi via AJAX --}}
            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" id="statusModalContent">
                        <div class="modal-body text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lengkapi Alamat -->
<div class="modal fade" id="catatanModal" tabindex="-1" aria-labelledby="catatanModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.offer.updateNote', $offer->id) }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="catatanModalLabel">Tambahkan Catatan Showroom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    {{-- <label for="alamat" class="form-label">Alamat Lengkap <small> (bisa tambahkan sharelok)</small></label> --}}
                    <textarea name="note" class="form-control" rows="3" required>{{ old('address', Auth::user()->address) }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {

        
        // Load form update status ke dalam modal
        $(document).on('click', '.btn-edit-status', function () {
            const offerId = $(this).data('id');
            const modalContent = $('#statusModalContent');

            modalContent.html(`
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            $.ajax({
                url: `/admin/offer/${offerId}/edit-status`,
                method: 'GET',
                success: function (html) {
                    modalContent.html(html);
                },
                error: function () {
                    modalContent.html(
                        '<div class="modal-body text-danger">Gagal memuat form status.</div>'
                    );
                }
            });
        });

        // Submit form update status
        $(document).on('submit', '#form-update-status', function (e) {
            e.preventDefault();

            const offerId = $('#modal-offer-id').val();
            const newStatus = $('#new-status').val();

            $.ajax({
                url: `/admin/offer/${offerId}/update-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function (res) {
                    $('#statusModal').modal('hide');

                    const badge = $(`.status-label-${offerId}`);
                    badge.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                    badge.removeClass('bg-warning bg-success bg-danger bg-secondary')
                         .addClass(getBadgeClass(newStatus));

                    alert(res.message); 
                },
                error: function (xhr) {
                    console.error('Update failed:', xhr.status, xhr.responseText);
                    alert('Failed to update status');
                }
            });

            function getBadgeClass(status) {
                switch (status) {
                    case 'pending': return 'bg-warning';
                    case 'accepted': return 'bg-success';
                    case 'rejected': return 'bg-danger';
                    default: return 'bg-secondary';
                }
            }
        });
    });
</script>
@endpush


@endsection
