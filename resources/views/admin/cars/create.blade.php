@extends('layouts.master')
@section('content')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet" />

    <style>
        .check-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        cursor: pointer;
        transition: 0.2s;
        user-select: none;
    }

    .check-badge:hover {
        background-color: #e2e6ea;
    }

    .check-badge input {
        display: none;
    }

    .check-badge.active {
        background-color: #cce5ff;
        border-color: #66afe9;
    }

    .check-badge i {
        font-size: 1rem;
    }

    .check-toggle-btn {
        margin-bottom: 10px;
    }
    </style>
@endpush

<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Create New Stock Car </div>
            </div>
            <!--end::Header-->

            <!--begin::Error Alert-->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!--end::Error Alert-->

            <!--begin::Form-->
            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-control select2 @error('user_id') is-invalid @enderror " name="user_id"
                            required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($user as $u)
                            <option value="{{ $u->id }}"
                                {{ old('user_id', auth()->user()->id) == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} ({{ $u->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <select name="brand" id="brand" class="form-control" required>
                            <option value="">-- Pilih Brand --</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>

                        @error('brand')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <select name="model" id="model" class="form-control" required disabled>
                            <option value="">-- Pilih Model --</option>
                        </select>
                        @error('model')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <select class="form-control select2Year @error('year') is-invalid @enderror" name="year"
                            id="year" required>
                            <option value="">-- Pilih Tahun --</option>
                            @for ($year = 2025; $year >= 2004; $year--)
                            <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}
                            </option>
                            @endfor
                        </select>
                        @error('year')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price_format" class="form-label">Price</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price_format"
                            value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : '' }}" required />

                        <input type="hidden" name="price" id="price" value="{{ old('price') }}" />

                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="transmission" class="form-label">Transmission</label>
                        <select name="transmission" id="transmission"
                            class="form-control @error('transmission') is-invalid @enderror" required>
                            <option value="">-- Pilih Transmission --</option>
                            <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>
                                Automatic</option>
                            <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual
                            </option>
                        </select>
                        @error('transmission')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea cols="10" rows="2" class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" required>{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label">Fuel Type</label>
                        <input type="text" class="form-control @error('fuel_type') is-invalid @enderror" id="fuel_type"
                            name="fuel_type" value="{{ old('fuel_type') }}" required />
                        @error('fuel_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="mileage" class="form-label">Mileage</label>
                        <input type="text" class="form-control @error('mileage') is-invalid @enderror"
                            id="mileage_format"
                            value="{{ old('mileage') ? number_format(old('mileage'), 0, ',', '.') : '' }}" required />

                        <input type="hidden" name="mileage" id="mileage" value="{{ old('mileage') }}" />

                        @error('mileage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror" id="color"
                            name="color" value="{{ old('color') }}" required />
                        @error('color')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="service_history" class="form-label">Last Service</label>
                        <input type="date" class="form-control @error('service_history') is-invalid @enderror"
                            id="service_history" name="service_history" value="{{ old('service_history') }}" required />
                        @error('service_history')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tax" class="form-label">Tax</label>
                        <input type="date" class="form-control @error('tax') is-invalid @enderror" id="tax" name="tax"
                            value="{{ old('tax') }}" required />
                        @error('tax')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="engine" class="form-label">Engine</label>
                        <input type="number" class="form-control @error('engine') is-invalid @enderror" id="engine"
                            name="engine" value="{{ old('engine') }}" required />
                        @error('engine')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="seat" class="form-label">Seat</label>
                        <input type="number" class="form-control @error('seat') is-invalid @enderror" id="seat"
                            name="seat" value="{{ old('seat') }}" required />
                        @error('seat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Completeness of Documents & Accessories</label>
                        <div class="d-flex flex-wrap gap-2">

                            <label class="check-badge {{ old('bpkb') ? 'active' : '' }}">
                                <input type="checkbox" name="bpkb" id="bpkb" value="1"
                                    {{ old('bpkb') ? 'checked' : '' }}>
                                <i class="bi bi-check-square"></i> BPKB
                            </label>

                            <label class="check-badge {{ old('spare_key') ? 'active' : '' }}">
                                <input type="checkbox" name="spare_key" id="spare_key" value="1"
                                    {{ old('spare_key') ? 'checked' : '' }}>
                                <i class="bi bi-key"></i> Kunci Cadangan
                            </label>

                            <label
                                class="check-badge {{ old('manual_book') ? 'active' : '' }}">
                                <input type="checkbox" name="manual_book" id="manual_book" value="1"
                                    {{ old('manual_book') ? 'checked' : '' }}>
                                <i class="bi bi-book"></i> Manual Book
                            </label>

                            <label
                                class="check-badge {{ old('service_book') ? 'active' : '' }}">
                                <input type="checkbox" name="service_book" id="service_book" value="1"
                                    {{ old('service_book') ? 'checked' : '' }}>
                                <i class="bi bi-journal-check"></i> Service Book
                            </label>

                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 check-toggle-btn"
                            onclick="toggleChecklist()">☑️ All</button>
                    </div>


                    <div class="mb-3">
                        <label for="sale_type" class="form-label">Sale Type</label>
                        <select name="sale_type" id="sale_type"
                            class="form-control @error('sale_type') is-invalid @enderror" required>
                            <option value="">-- Pilih sale_type --</option>
                            <option value="showroom" {{ old('sale_type') == 'showroom' ? 'selected' : '' }}>Showroom
                            </option>
                            <option value="user" {{ old('sale_type') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('sale_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label for="photos" class="form-label">Photo Mobil</label>
                    <div id="photo-wrapper" class="row sortable-photo-wrapper">
                        {{-- Template satu photo --}}
                        <div class="col-md-3 mb-3 photo-group">
                            <div class="card position-relative text-center h-100 shadow-sm p-2">
                                <img src="{{ asset('image/NoImage.png') }}" class="img-preview img-fluid mb-2"
                                    style="max-height: 150px;">
                                <input type="file" name="photos[]" class="form-control photo-input mb-2"
                                    accept="image/*" required>
                                <input type="hidden" name="photo_order[]" value="1" class="photo-order">
                                <button type="button" class="btn btn-danger btn-sm w-100 btn-remove-photo">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <button type="button" id="btn-add-photo" class="btn btn-info px-4">+ Tambah Foto</button>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
    <!--end::Container-->
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2, .select2Year').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: '-- Pilih --',

        });
        $('#brand, #model').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: '-- Pilih --',
        });

        $('#brand').on('change', function () {
            const brand = $(this).val();
            $('#model').prop('disabled', true).empty().append('<option value="">Loading...</option>');

            if (brand) {
                $.get('/api/models', {
                    brand: brand
                }, function (data) {
                    $('#model').empty().append('<option value="">-- Pilih Model --</option>');
                    $.each(data, function (i, model) {
                        $('#model').append(
                            `<option value="${model}">${model}</option>`);
                    });
                    $('#model').prop('disabled', false).trigger('change');
                });
            } else {
                $('#model').empty().append('<option value="">-- Pilih Model --</option>').prop(
                    'disabled', true);
            }
        });

    });

    // Format input price to Rupiah
    function formatRupiah(angka) {
        return angka.replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputFormatted = document.getElementById('price_format');
        const inputHidden = document.getElementById('price');

        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            inputHidden.value = clean;
        });

        const inputMileageFormatted = document.getElementById('mileage_format');
        const inputMileageHidden = document.getElementById('mileage');

        inputMileageFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            inputMileageHidden.value = clean;
        });
    });
    // Menangani penambahan dan penghapusan foto
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('photo-wrapper');
        const btnAdd = document.getElementById('btn-add-photo');

        // Tambah foto baru
        btnAdd.addEventListener('click', function () {
            const newCol = document.createElement('div');
            newCol.classList.add('col-md-3', 'mb-3', 'photo-group');

            newCol.innerHTML = `
            <div class="card position-relative text-center h-100 shadow-sm p-2">
                <img src="{{ asset('image/NoImage.png') }}" class="img-preview img-fluid mb-2" style="max-height: 150px;">
                <input type="file" name="photos[]" class="form-control photo-input mb-2" accept="image/*" required>
                <input type="hidden" name="photo_order[]" value="0" class="photo-order">
                <button type="button" class="btn btn-danger btn-sm w-100 btn-remove-photo">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        `;
            wrapper.appendChild(newCol);
        });

        // Preview image
        wrapper.addEventListener('change', function (e) {
            if (e.target.classList.contains('photo-input')) {
                const preview = e.target.closest('.photo-group').querySelector('.img-preview');
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => preview.src = e.target.result;
                    reader.readAsDataURL(file);
                }
            }
        });

        // Hapus photo group
        wrapper.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-photo')) {
                const photo = e.target.closest('.photo-group');
                photo.remove();
            }
        });

        // Drag & Drop dengan SortableJS
        new Sortable(wrapper, {
            animation: 150,
            draggable: '.photo-group',
            onEnd: updatePhotoOrder,
        });

        // Update order saat submit
        document.querySelector('form').addEventListener('submit', updatePhotoOrder);

        function updatePhotoOrder() {
            const groups = wrapper.querySelectorAll('.photo-group');
            groups.forEach((group, index) => {
                group.querySelector('.photo-order').value = index + 1;
            });
        }
    });

    // ceklis button kelengkapan
    function toggleChecklist() {
        const labels = document.querySelectorAll('.check-badge');
        const allChecked = [...labels].every(label => label.classList.contains('active'));

        labels.forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox.checked = !allChecked;
            label.classList.toggle('active', !allChecked);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.check-badge input[type="checkbox"]').forEach(cb => {
            cb.addEventListener('change', function () {
                this.closest('.check-badge').classList.toggle('active', this.checked);
            });
        });
    });

</script>

@endpush

@endsection
