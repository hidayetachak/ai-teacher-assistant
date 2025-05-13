@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('page-title', 'Teacher Dashboard')

@section('dashboard-content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Resource Generator</h2>
    <a href="{{ route('content.create.resource') }}" class="btn btn-primary">
  <i class="bi bi-plus-lg me-1"></i> Add Resource 
</a>

  </div>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>Topic</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($resource as $lesson)
            <tr>
                <td>{{ $lesson->topic }}</td>
              

                <td>{{ $lesson->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('content.download', $lesson->id) }}" class="btn btn-sm btn-success me-1" title="Download">
                        <i class="bi bi-download"></i>
                    </a>
                    <a href="{{ route('content.view', $lesson->id) }}" class="btn btn-sm btn-info me-1" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                    <form action="{{ route('content.destroy', $lesson->id) }}" method="POST" class="d-inline" 
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