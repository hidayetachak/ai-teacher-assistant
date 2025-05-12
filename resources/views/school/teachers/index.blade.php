@extends('layouts.schoolDashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('dashboard-content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Teachers</h2>
    <a href="{{ route('school.teachers.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> Add Teacher
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($teachers as $teacher)
          <tr>
            <td>{{ $teacher->name }}</td>
            <td>{{ $teacher->email }}</td>
            <td>
              <a href="{{ route('school.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-info me-1" title="Edit">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('school.teachers.delete', $teacher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this teacher?')">
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
