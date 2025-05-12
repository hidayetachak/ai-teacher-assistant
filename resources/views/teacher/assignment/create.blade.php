@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Teacher Dashboard')

@section('dashboard-content')
<div class="card shadow-sm">
    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: var(--primary-color);">
        <h2 class="mb-0">Create Assignments</h2>
        <a href="{{ route('content.assignment') }}" class="btn btn-light" style="color: var(--primary-color);">
            <i class="bi bi-card-list me-1"></i> View All Assignments
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('assignment.store') }}" method="POST">
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
                <label for="num_questions" class="form-label">Number of Questions</label>
                <input type="number" class="form-control @error('num_questions') is-invalid @enderror" id="num_questions" name="num_questions" required>
                @error('num_questions')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="question_type" class="form-label">Question Type</label>
                <select class="form-select @error('question_type') is-invalid @enderror" id="question_type" name="question_type" required>
                    <option value="">-- Select Type --</option>
                    <option value="MCQ">Multiple Choice</option>
                    <option value="True/False">True/False</option>
                    <option value="Short Answer">Short Answer</option>
                </select>
                @error('question_type')
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

        @if(isset($lessonPlan))
            <div class="mt-4">
                <h3 class="mb-3">Generated Lesson Plan</h3>
                <pre class="border rounded p-3 bg-light">{{ $lessonPlan }}</pre>

                <div class="d-flex gap-2">
                    <a href="{{ route('content.export.pdf', $content) }}" class="btn btn-outline-primary">
                        <i class="bi bi-filetype-pdf me-1"></i> Export as PDF
                    </a>
                    <button class="btn btn-outline-secondary" onclick="copyToClipboard(`{!! addslashes($lessonPlan) !!}`)">
                        <i class="bi bi-clipboard me-1"></i> Copy to Clipboard
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => alert('Copied to clipboard!'));
}
</script>
@endsection
