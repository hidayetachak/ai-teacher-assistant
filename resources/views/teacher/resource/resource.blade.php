@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('page-title', 'Teacher Dashboard')

@section('dashboard-content')
<div class="card shadow-sm">
    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: var(--primary-color);">
        <h2 class="mb-0">Generate Resources</h2>
        <a href="{{ route('content.resource') }}" class="btn btn-light" style="color: var(--primary-color);">
            <i class="bi bi-card-list me-1"></i> View All Resources
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('resource.store'') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="topic" class="form-label">Topic</label>
                <input type="text" class="form-control @error('topic') is-invalid @enderror" id="topic" name="topic" required>
                @error('topic')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="grade_level" class="form-label">Grade Level</label>
                <select class="form-select @error('grade_level') is-invalid @enderror" id="grade_level" name="grade_level" required>
                    <option value="">-- Select Grade --</option>
                    <option value="K-2">K-2</option>
                    <option value="3-5">3-5</option>
                    <option value="6-8">6-8</option>
                    <option value="9-12">9-12</option>
                </select>
                @error('grade_level')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">Tags (comma-separated)</label>
                <input type="text" class="form-control" id="tags" name="tags">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-lightning-fill me-1"></i> Generate
            </button>
        </form>

    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('Copied to clipboard!'));
}
</script>
@endsection
