@extends('layouts.admin')

@section('title', 'Super Admin Dashboard')

@section('page-title', 'Super Admin Dashboard')

@section('dashboard-content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h2>Admin Dashboard</h2>
    </div>
    <div class="card-body">
        <h3>System Usage Metrics</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usageStats as $stat)
                    <tr>
                        <td>{{ $stat->type }}</td>
                        <td>{{ $stat->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Manage Users</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form action="{{ route('admin.update.user', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="role" class="form-select d-inline w-auto">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>

                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection