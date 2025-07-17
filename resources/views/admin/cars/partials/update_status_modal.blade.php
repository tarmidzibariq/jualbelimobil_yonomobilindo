<div class="modal-header">
  <h5 class="modal-title">Update Car Status</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
  <form id="form-update-status">
    @csrf
    <input type="hidden" name="car_id" id="modal-car-id" value="{{ $car->id }}">
    <div class="mb-3">
      <label for="new-status" class="form-label">Select Status</label>
      <select name="status" id="new-status" class="form-select">
        @foreach(['available', 'pending_check', 'sold', 'under_review'] as $status)
          <option value="{{ $status }}" {{ $car->status === $status ? 'selected' : '' }}>
            {{ ucfirst($status) }}
          </option>
        @endforeach
      </select>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
  <button type="submit" form="form-update-status" class="btn btn-primary">Save</button>
</div>
