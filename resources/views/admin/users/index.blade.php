@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Users</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th> <!-- Optional -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
        <!-- Pagination Links -->
        <div class="mt-3">
           {{ $users->links() }}
        </div>
</div>
@endsection
