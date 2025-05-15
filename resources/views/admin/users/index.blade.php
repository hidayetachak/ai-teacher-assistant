@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section('dashboard-content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Users</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> Add User
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Account Creation</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at->format('d M Y') }}</td>
          <td>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this user?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash-fill"></i>
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center">No users found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection