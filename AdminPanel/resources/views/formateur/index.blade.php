@extends('layouts.app')

@section('title', 'Formateurs')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Formateurs Table</h4>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addFormateurModal">
                                <i class="fas fa-user-plus"></i> Add Formateur
                            </button>
                        </div>

                        <!-- Add Formateur Modal -->
                        <div class="modal fade" id="addFormateurModal" tabindex="-1" role="dialog" aria-labelledby="addFormateurModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="addFormateurForm" method="post" action="{{ route('formateurs.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addFormateurModalLabel">Add Formateur</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="formateurName">Name</label>
                                                <input type="text" class="form-control" id="formateurName" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="formateurPrenom">Prenom</label>
                                                <input type="text" class="form-control" id="formateurPrenom" name="prenom" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="formateurEmail">Email</label>
                                                <input type="email" class="form-control" id="formateurEmail" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="formateurPassword">Password</label>
                                                <input type="password" class="form-control" id="formateurPassword" name="password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="formateurPicture">Profile Picture</label>
                                                <input type="file" class="form-control-file" id="formateurPicture" name="picture">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Formateur</button>
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
                                        <th>Prenom</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formateurs as $formateur)
                                        <tr>
                                            <td class="py-1">
                                                @if ($formateur->picture)
                                                    <img src="{{ asset('storage/' . $formateur->picture) }}" alt="Profile Picture" class="img-fluid rounded" style="max-width: 50px; height: auto;">
                                                @else
                                                    <img src="{{ asset('path/to/default/profile.png') }}" alt="Profile Picture" class="img-fluid rounded" style="max-width: 50px; height: auto;">
                                                @endif
                                            </td>
                                            <td>{{ $formateur->name }}</td>
                                            <td>{{ $formateur->prenom }}</td>
                                            <td>{{ $formateur->role }}</td>
                                            <td>{{ $formateur->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($formateur->created_at)->toDateString() }}</td>
                                            <td>
                                                <div class="d-inline-flex align-items-center">
                                                    <!-- Edit Button -->
                                                    <a href="#" class="btn btn-sm btn-outline-secondary edit-formateur mr-1 mb-2" data-toggle="modal" data-target="#editFormateurModal{{ $formateur->id }}" data-id="{{ $formateur->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('formateurs.destroy', $formateur->id) }}" method="POST" class="delete-form mt-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this formateur?');">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Formateur Modal -->
                                        <div class="modal fade" id="editFormateurModal{{ $formateur->id }}" tabindex="-1" role="dialog" aria-labelledby="editFormateurModalLabel{{ $formateur->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form method="post" action="{{ route('formateurs.update', $formateur->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editFormateurModalLabel{{ $formateur->id }}">Edit Formateur</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="editFormateurName{{ $formateur->id }}">Name</label>
                                                                <input type="text" class="form-control" id="editFormateurName{{ $formateur->id }}" name="name" value="{{ $formateur->name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editFormateurPrenom{{ $formateur->id }}">Prenom</label>
                                                                <input type="text" class="form-control" id="editFormateurPrenom{{ $formateur->id }}" name="prenom" value="{{ $formateur->prenom }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editFormateurEmail{{ $formateur->id }}">Email</label>
                                                                <input type="email" class="form-control" id="editFormateurEmail{{ $formateur->id }}" name="email" value="{{ $formateur->email }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editFormateurPicture{{ $formateur->id }}">Profile Picture</label>
                                                                <input type="file" class="form-control-file" id="editFormateurPicture{{ $formateur->id }}" name="picture">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Formateur</button>
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
</div>
@endsection
