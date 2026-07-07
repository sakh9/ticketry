@extends('layouts.adminapp')
@section('title', 'Admin Locations')
@section('content')

    <div class="container mt-4">
        <h2>Location Management</h2>

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

        <!-- Add Location Form -->
        <div class="card mb-4">
            <div class="card-header"><strong>Add New Location</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.locations.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Place/Venue *</label>
                            <input type="text" name="place" class="form-control" placeholder="e.g., Jakarta Convention Center" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Address *</label>
                            <input type="text" name="address" class="form-control" placeholder="e.g., Jl. Gatot Subroto No.1" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">City *</label>
                            <select name="city" class="form-control" required>
                                <option value="">-- Select City --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Place/Venue</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $loc)
                        <tr class="{{ $loc->is_active ? '' : 'table-secondary' }}">
                            <td>{{ $loc->place }}</td>
                            <td>{{ $loc->address }}</td>
                            <td>{{ $loc->city }}</td>
                            <td>
                                @if($loc->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-info btn-sm" onclick="editLocation({{ $loc->id }}, '{{ $loc->place }}', '{{ $loc->address }}', '{{ $loc->city }}')">Edit</button>
                                    <form method="POST" action="{{ route('admin.locations.toggle', $loc->id) }}">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">{{ $loc->is_active ? 'Deactivate' : 'Activate' }}</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.locations.destroy', $loc->id) }}" onsubmit="return confirm('Delete this location?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="editForm">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Place/Venue</label>
                            <input type="text" name="place" id="editPlace" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" id="editAddress" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <select name="city" id="editCity" class="form-control" required>
                                <option value="">-- Select City --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editLocation(id, place, address, city) {
            document.getElementById('editForm').action = '/admin/locations/' + id;
            document.getElementById('editPlace').value = place;
            document.getElementById('editAddress').value = address;
            document.getElementById('editCity').value = city;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert-dismissible').forEach(a => new bootstrap.Alert(a).close());
            }, 5000);
        });
    </script>
@endsection