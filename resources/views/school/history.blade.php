@extends('layouts.schoolDashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('dashboard-content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Payments History</h2>
    <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>Package Name</th>
          <th>Paymnet</th>
          <th>credits</th>
          <th>date</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($records as $record)
          <tr>
            <td>{{ $record->package->title ?? 'N/A' }}</td>
            <td>${{ number_format($record->amount) }}</td>
            <td>{{ $record->credits }}</td>
            <td>{{ $record->created_at->format('d M Y') }}</td>

          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
