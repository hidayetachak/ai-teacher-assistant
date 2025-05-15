@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section('dashboard-content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="text-center mb-4">Add New Package</h2>
            <form action="{{ route('packages.store') }}" method="POST" class="card p-4">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Package Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter package title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter package description" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Features</label>
                    <div id="features-container">
                        <div class="feature-input-group d-flex align-items-center mb-2">
                            <input type="text" name="features[]" class="form-control" placeholder="Enter feature" required>
                            <button type="button" class="btn btn-danger ms-2 remove-feature-btn" onclick="removeFeature(this)" style="display: none;">×</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary mt-2" onclick="addFeature()">Add Another Feature</button>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" step="0.01" class="form-control" placeholder="Enter package price" required>
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Duration (in days)</label>
                    <input type="number" name="duration" id="duration" class="form-control" placeholder="Enter package duration in days" required>
                </div>

                <div class="mb-3">
                    <label for="downloads" class="form-label">Credits</label>
                    <input type="number" name="downloads" id="downloads" class="form-control" placeholder="Enter number of downloads" required>
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status</label>
                    <select name="is_active" id="is_active" class="form-select" required>
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="is_featured" class="form-label">Featured Package</label>
                    <select name="is_featured" id="is_featured" class="form-select" required>
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="recovery_payment" class="form-label">Subscription</label>
                    <select name="recovery_payment" class="form-select" required>
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-dark w-100">Add Package</button>
            </form>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function addFeature() {
        const container = document.getElementById('features-container');
        const featureGroups = container.getElementsByClassName('feature-input-group');

        if (featureGroups.length === 1) {
            featureGroups[0].querySelector('.remove-feature-btn').style.display = 'block';
        }

        const newFeatureGroup = document.createElement('div');
        newFeatureGroup.className = 'feature-input-group d-flex align-items-center mb-2';
        newFeatureGroup.innerHTML = `
            <input type="text" name="features[]" class="form-control" placeholder="Enter feature" required>
            <button type="button" class="btn btn-danger ms-2 remove-feature-btn" onclick="removeFeature(this)">×</button>
        `;
        container.appendChild(newFeatureGroup);
    }

    function removeFeature(button) {
        const container = document.getElementById('features-container');
        const featureGroups = container.getElementsByClassName('feature-input-group');

        if (featureGroups.length > 1) {
            button.closest('.feature-input-group').remove();

            if (featureGroups.length === 1) {
                featureGroups[0].querySelector('.remove-feature-btn').style.display = 'none';
            }
        }
    }
</script>
@endsection