@extends('layouts.adminapp')
@section('title', 'Admin Locations')
@section('content')

    <div class="container mt-4">
        <h2>Admin Management</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <!-- Add Admin Form -->
        <div class="card mb-4">
            <div class="card-header"><strong>Add New Admin</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.admins.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="nama_admin" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email_admin" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Add Admin</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Admins Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->id_admin }}</td>
                            <td>{{ $admin->nama_admin }}</td>
                            <td>{{ $admin->email_admin }}</td>
                            <td>{{ $admin->created_at->format('d M Y') }}</td>
                            <td>
                                @if($admin->id_admin !== Auth::guard('admin')->id())
                                    <form method="POST" action="{{ route('admin.admins.destroy', $admin->id_admin) }}" onsubmit="return confirm('Delete this admin?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @else
                                    <span class="badge bg-info">You</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert-dismissible').forEach(a => new bootstrap.Alert(a).close());
            }, 5000);
        });
    </script>
@endsection