<div class="modal-header">
  <h5 class="modal-title">Perbarui Status Permintaan Penjualan</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
  <form id="form-update-status">
    @csrf
    <input type="hidden" name="offer_id" id="modal-offer-id" value="{{ $offer->id }}">
    <div class="mb-3">
      <label for="new-status" class="form-label">Select Status</label>
      <select name="status" id="new-status" class="form-select">
        @foreach(['accepted', 'pending', 'rejected', 'sold'] as $status)
          <option value="{{ $status }}" {{ $offer->status === $status ? 'selected' : '' }}>
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
