<div class="modal-header">
    <h5 class="modal-title" id="carModalLabel">Down Payment DP #{{ $downPayment->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <table class="table table-bordered text-capitalize">
        <tr>
            <th>ID</th>
            <td>{{ $downPayment->id }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ \Carbon\Carbon::parse($downPayment->created_at)->format('d M Y - H:i') }}</td>
        </tr>
        <tr>
            <th>Nama User</th>
            <td>{{ $downPayment->user->name }}</td>
        </tr>
        <tr>
            <th>No. HP User</th>
            <td>{{ $downPayment->user->phone }}</td>
        </tr>
        <tr>
            <th>Mobil</th>
            <td>#{{ $downPayment->car_id }} {{ $downPayment->car->brand }} {{ $downPayment->car->model }}</td>
        </tr>
        <tr>
            <th>Appointment Date</th>
            @if ($downPayment->payment_status === 'confirmed' )
                <td><span class=" bg-info">{{ \Carbon\Carbon::parse($downPayment->inspection_date)->format('d M Y - H:i') }}</span></td> 
                
            @else
                <td>{{ \Carbon\Carbon::parse($downPayment->inspection_date)->format('d M Y - H:i') }}</td> 
                
            @endif
        </tr>
        <tr>
            <th>Amount</th>
            <td>Rp {{ number_format($downPayment->amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th colspan="2" class="text-muted">Informasi Pembayaran</th>
        </tr>
        <tr>
            <th>Order ID</th>
            <td>{{ $downPayment->order_id ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status Pembayaran</th>
            <td>
                @switch($downPayment->payment_status)
                    @case('pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @break
                    @case('confirmed')
                        <span class="badge bg-success">Confirmed</span>
                        @break
                    @case('cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                        @break
                    @case('expired')
                        <span class="badge bg-danger">Expired</span>
                        @break
                    @default
                        <span class="badge bg-secondary">{{ ucfirst($downPayment->payment_status) }}</span>
                @endswitch
            </td>
        </tr>
        <tr>
            <th>Tanggal Pembayaran</th>
            <td>
                @if ($downPayment->payment_date)
                    {{ \Carbon\Carbon::parse($downPayment->payment_date)->format('d M Y - H:i') }}
                @else
                    -
                @endif
            </td>
        </tr>
    </table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
