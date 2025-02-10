@extends('layouts.app')

@section('title', 'Cours')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Liste des Cours</h4>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCoursModal">
                                <i class="fas fa-plus"></i> Ajouter un Cours
                            </button>
                        </div>

                        <!-- Add Cours Modal -->
                        <div class="modal fade" id="addCoursModal" tabindex="-1" role="dialog" aria-labelledby="addCoursModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="addCoursForm" method="POST" action="{{ route('cours.store') }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addCoursModalLabel">Ajouter un Cours</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="titre">Titre</label>
                                                <input type="text" class="form-control" id="titre" name="titre" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Description</th>
                                        <th>Date de création</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cours as $course)
                                        <tr>
                                            <td>{{ $course->titre }}</td>
                                            <td>{{ $course->description }}</td>
                                            <td>{{ \Carbon\Carbon::parse($course->created_at)->toDateString() }}</td>
                                            <td>
                                                <div class="d-inline-flex align-items-center">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary edit-cours mr-1" 
                                                       data-toggle="modal" 
                                                       data-target="#editCoursModal{{ $course->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('cours.destroy', $course->id) }}" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?');">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#addCoursForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    alert('Cours ajouté avec succès!');
                    window.location.reload();
                } else {
                    alert('Erreur: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Erreur lors de l\'ajout du cours');
                console.log(xhr.responseText);
            }
        });
    });
});
</script>
@endsection
