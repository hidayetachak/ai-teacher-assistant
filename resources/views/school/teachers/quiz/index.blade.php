@extends('layouts.schoolDashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('dashboard-content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quizzes</h2>
    <a href="{{ route('content.create.quiz') }}" class="btn btn-primary">
  <i class="bi bi-plus-lg me-1"></i> Add Quiz
</a>

  </div>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>Topic</th>
          <th>Grade Level</th>
          <th>No of Questions</th>
          <th>Question Types</th>
          <th>Tags</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->topic }}</td>
                <td>{{ $quiz->grade_level }}</td>
                <td>{{ $quiz->num_questions }}</td>
                <td>{{ $quiz->question_type }}</td>
                <td>
                    {{ is_array($quiz->tags) 
                        ? implode(', ', $quiz->tags) 
                        : $quiz->tags }}
                </td>
                <td>{{ $quiz->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('content.download', $quiz->id) }}" class="btn btn-sm btn-success me-1" title="Download">
                        <i class="bi bi-download"></i>
                    </a>
                    <a href="{{ route('content.view', $quiz->id) }}" class="btn btn-sm btn-info me-1" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                    <form action="{{ route('content.destroy', $quiz->id) }}" method="POST" class="d-inline" 
                          onsubmit="return confirm('Are you sure you want to delete this item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection