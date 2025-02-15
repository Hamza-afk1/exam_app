@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Admins Table</h4>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addUserModal">
                                <i class="fas fa-user-plus"></i> Add Admin
                            </button>
                        </div>

                        <!-- Add User Modal -->
                        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="addUserForm" method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addUserModalLabel">Add Admin</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="userName">Name</label>
                                                <input type="text" class="form-control" id="userName" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="userEmail">Email</label>
                                                <input type="email" class="form-control" id="userEmail" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="userPassword">Password</label>
                                                <input type="password" class="form-control" id="userPassword" name="password" required>
                                            </div>
                                            <input type="hidden" name="role" value="admin">
                                            <div class="form-group">
                                                <label for="userPicture">Profile Picture</label>
                                                <input type="file" class="form-control-file" id="userPicture" name="picture">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Admin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Profile Picture</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="py-1">
                                                @if ($user->picture)
                                                    <img src="{{ asset('storage/' . $user->picture) }}" alt="Profile Picture" class="img-fluid rounded" style="max-width: 50px; height: auto;">
                                                @else
                                                    <img src="{{ asset('images/faces/face1.jpg') }}" alt="Profile Picture" class="img-fluid rounded" style="max-width: 50px; height: auto;">
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge
                                                    @if ($user->role === 'admin') badge-primary
                                                    @elseif ($user->role === 'formateur') badge-info
                                                    @elseif ($user->role === 'stagiaire') badge-success
                                                    @else badge-secondary
                                                    @endif">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="d-inline-flex align-items-center">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary edit-user mr-1" 
                                                       data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit User Modal -->
                                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" 
                                             aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit Admin</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="editUserName{{ $user->id }}">Name</label>
                                                                <input type="text" class="form-control" id="editUserName{{ $user->id }}" 
                                                                       name="name" value="{{ $user->name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editUserEmail{{ $user->id }}">Email</label>
                                                                <input type="email" class="form-control" id="editUserEmail{{ $user->id }}" 
                                                                       name="email" value="{{ $user->email }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editUserPassword{{ $user->id }}">New Password (leave empty to keep current)</label>
                                                                <input type="password" class="form-control" id="editUserPassword{{ $user->id }}" 
                                                                       name="password">
                                                            </div>
                                                            <input type="hidden" name="role" value="admin">
                                                            <div class="form-group">
                                                                <label for="editUserPicture{{ $user->id }}">Profile Picture</label>
                                                                <input type="file" class="form-control-file" id="editUserPicture{{ $user->id }}" 
                                                                       name="picture">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                Copyright © {{ date('Y') }}. All rights reserved.
            </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i>
            </span>
        </div>
    </footer>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Fermer les alertes après 3 secondes
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    });
</script>
@endpush