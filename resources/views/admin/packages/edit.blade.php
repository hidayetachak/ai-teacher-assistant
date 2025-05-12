@extends('layouts.admin')

@section('title', 'Super Admin Dashboard')

@section('page-title', 'Super Admin Dashboard')

@section('dashboard-content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="text-center mb-4">Edit Package</h2>
            <form action="{{ route('packages.update', $package->id) }}" method="POST" class="card p-4">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Package Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $package->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $package->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Features</label>
                    <div id="features-container">
                        @foreach ($package->features as $feature)
                        <div class="feature-input-group d-flex align-items-center mb-2">
                            <input type="text" name="features[]" class="form-control" value="{{ $feature }}" required>
                            <button type="button" class="btn btn-danger ms-2 remove-feature-btn" onclick="removeFeature(this)">×</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-secondary mt-2" onclick="addFeature()">Add Feature</button>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" step="0.01" class="form-control" value="{{ old('price', $package->price) }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="duration" class="form-label">Duration (days)</label>
                        <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration', $package->duration) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="credits" class="form-label">credits</label>
                        <input type="number" name="credits" id="credits" class="form-control" value="{{ old('credits', $package->credits) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-select" required>
                            <option value="1" {{ $package->is_active == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $package->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="is_featured" class="form-label">Feature</label>
                        <select name="is_featured" id="is_featured" class="form-select" required>
                            <option value="1" {{ $package->is_featured == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $package->is_featured == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="recovery_payment" class="form-label">Subscription</label>
                        <select name="recovery_payment" class="form-select" required>
                            <option value="no" {{ $package->recovery_payment == 'no' ? 'selected' : '' }}>No</option>
                            <option value="yes" {{ $package->recovery_payment == 'yes' ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100">Update Package</button>
            </form>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function addFeature() {
        const container = document.getElementById('features-container');
        const newFeature = document.createElement('div');
        newFeature.className = 'feature-input-group d-flex align-items-center mb-2';
        newFeature.innerHTML = `
            <input type="text" name="features[]" class="form-control" required>
            <button type="button" class="btn btn-danger ms-2 remove-feature-btn" onclick="removeFeature(this)">×</button>
        `;
        container.appendChild(newFeature);
    }

    function removeFeature(button) {
        button.closest('.feature-input-group').remove();
    }
</script>
@endsection