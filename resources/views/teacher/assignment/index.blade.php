@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('page-title', 'Teacher Dashboard')

@section('dashboard-content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Assignments</h2>
    <a href="{{ route('content.create.assignment') }}" class="btn btn-primary">
  <i class="bi bi-plus-lg me-1"></i> Add Assignment
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
      @foreach ($assignment as $assignments)
            <tr>
                <td>{{ $assignments->topic }}</td>
                <td>{{ $assignments->grade_level }}</td>
                <td>{{ $assignments->num_questions }}</td>
                <td>{{ $assignments->question_type }}</td>
                <td>
                    {{ is_array($assignments->tags) 
                        ? implode(', ', $assignments->tags) 
                        : $assignments->tags }}
                </td>
                <td>{{ $assignments->created_at->format('Y-m-d') }}</td>
                <td>
                  <a href="#" class="btn btn-sm btn-success me-1" title="Download"><i class="bi bi-download"></i></a>
                  <a href="#" class="btn btn-sm btn-info me-1" title="View"><i class="bi bi-eye"></i></a>
                  <a href="#" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection