<div class="modal-header">
  <h5 class="modal-title" id="carModalLabel">Car Detail: {{ $car->brand }} {{ $car->model }}</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <table class="table table-bordered">
    <tr><th>ID</th><td>{{ $car->id }}</td></tr>
    <tr><th>User</th><td>{{ $car->user->name ?? 'N/A' }}</td></tr>
    <tr><th>Brand</th><td>{{ $car->brand }}</td></tr>
    <tr><th>Model</th><td>{{ $car->model }}</td></tr>
    <tr><th>Year</th><td>{{ $car->year }}</td></tr>
    <tr><th>Price</th><td>{{ 'Rp '.number_format($car->price, 0, ',', '.') }}</td></tr>
    <tr><th>Transmission</th><td>{{ $car->transmission }}</td></tr>
    <tr><th>Description</th><td>{{ $car->description }}</td></tr>
    <tr><th>Service History</th><td>{{ $car->service_history }}</td></tr>
    <tr><th>Fuel Type</th><td>{{ $car->fuel_type }}</td></tr>
    <tr><th>Mileage</th><td>{{ number_format($car->mileage, 0, ',', '.') }}</td></tr>
    <tr><th>Sale Type</th><td>{{ $car->sale_type }}</td></tr>
    <tr><th>Status</th><td>{{ $car->status }}</td></tr>
    <tr><th>Created At</th><td>{{ $car->created_at }}</td></tr>
    <tr><th>Updated At</th><td>{{ $car->updated_at }}</td></tr>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
