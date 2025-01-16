@extends('layouts.app')

@section('title', 'Stagiaires')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Stagiaires Table</h4>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addStagiaireModal">
                                <i class="fas fa-user-plus"></i> Add Stagiaire
                            </button>
                        </div>

                        <!-- Add Stagiaire Modal -->
                        <div class="modal fade" id="addStagiaireModal" tabindex="-1" role="dialog" aria-labelledby="addStagiaireModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="addStagiaireForm" method="post" action="{{ route('stagiaire.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addStagiaireModalLabel">Add Stagiaire</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="stagiaireName">Name</label>
                                                <input type="text" class="form-control" id="stagiaireName" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stagiairePrenom">Prenom</label>
                                                <input type="text" class="form-control" id="stagiairePrenom" name="prenom" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stagiaireGroupe">Groupe</label>
                                                <input type="text" class="form-control" id="stagiaireGroupe" name="groupe" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stagiaireEmail">Email</label>
                                                <input type="email" class="form-control" id="stagiaireEmail" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stagiairePassword">Password</label>
                                                <input type="password" class="form-control" id="stagiairePassword" name="password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stagiairePicture">Profile Picture</label>
                                                <input type="file" class="form-control-file" id="stagiairePicture" name="picture">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Stagiaire</button>
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
                                        <th>Groupe</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stagiaires as $stagiaire)
                                        <tr>
                                            <td class="py-1">
                                                @if ($stagiaire->picture)
                                                    <img src="{{ asset('storage/' . $stagiaire->picture) }}" alt="Profile Picture" class="img-fluid rounded" style="max-width: 50px; height: auto;">
                                                @else
                                                    <img src="{{ asset('path/to/default/profile.png') }}" alt="Profile Picture" class="img-fluid rounded" style="max-width: 50px; height: auto;">
                                                @endif
                                            </td>
                                            <td>{{ $stagiaire->name }}</td>
                                            <td>{{ $stagiaire ->prenom }}</td>
                                            <td>{{ $stagiaire->groupe }}</td>
                                            <td>{{ $stagiaire->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($stagiaire->created_at)->toDateString() }}</td>
                                            <td>
                                                <div class="d-inline-flex align-items-center">
                                                    <!-- Edit Button -->
                                                    <a href="#" class="btn btn-sm btn-outline-secondary edit-stagiaire mr-1 mb-2" data-toggle="modal" data-target="#editStagiaireModal{{ $stagiaire->id }}" data-id="{{ $stagiaire->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('stagiaire.destroy', $stagiaire->id) }}" method="POST" class="delete-form mt-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this stagiaire?');">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Stagiaire Modal -->
                                        <div class="modal fade" id="editStagiaireModal{{ $stagiaire->id }}" tabindex="-1" role="dialog" aria-labelledby="editStagiaireModalLabel{{ $stagiaire->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form method="post" action="{{ route('stagiaire.update', $stagiaire->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editStagiaireModalLabel{{ $stagiaire->id }}">Edit Stagiaire</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="editStagiaireName{{ $stagiaire->id }}">Name</label>
                                                                <input type="text" class="form-control" id="editStagiaireName{{ $stagiaire->id }}" name="name" value="{{ $stagiaire->name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editStagiairePrenom{{ $stagiaire->id }}">Prenom</label>
                                                                <input type="text" class="form-control" id="editStagiairePrenom{{ $stagiaire->id }}" name="prenom" value="{{ $stagiaire->prenom }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editStagiaireGroupe{{ $stagiaire->id }}">Groupe</label>
                                                                <input type="text" class="form-control" id="editStagiaireGroupe{{ $stagiaire->id }}" name="groupe" value="{{ $stagiaire->groupe }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editStagiaireEmail{{ $stagiaire->id }}">Email</label>
                                                                <input type="email" class="form-control" id="editStagiaireEmail{{ $stagiaire->id }}" name="email" value="{{ $stagiaire->email }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editStagiairePicture{{ $stagiaire->id }}">Profile Picture</label>
                                                                <input type="file" class="form-control-file" id="editStagiairePicture{{ $stagiaire->id }}" name="picture">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Stagiaire</button>
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