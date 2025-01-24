@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif


                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Liste des Groupes</h4>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addGroupeModal">
                                <i class="fas fa-plus"></i> Ajouter Groupe
                            </button>
                        </div>

                        <!-- Barre de recherche -->
                        <div class="mb-3">
                            <input type="text" id="searchGroupe" class="form-control" placeholder="Rechercher un groupe...">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom du Groupe</th>
                                        <th>Nombre de Stagiaires</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupes as $groupe)
                                        <tr>
                                            <td>{{ $groupe->nom }}</td>
                                            <td>{{ $groupe->stagiaires_count }}</td>
                                            <td>
                                                <a href="{{ route('groupes.show', $groupe->id) }}" 
                                                   class="btn btn-sm btn-info mr-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-warning mr-1" 
                                                        data-toggle="modal" 
                                                        data-target="#editGroupeModal{{ $groupe->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('groupes.destroy', $groupe->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal de modification -->
                                        @include('groupes.partials.edit-modal', ['groupe' => $groupe])
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

<!-- Modal d'ajout -->
@include('groupes.partials.add-modal')

@push('scripts')
<script>
$(document).ready(function() {
    // Faire disparaître les alertes après 3 secondes
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);

    // Réouvrir le modal si nécessaire
    @if(session('modal') == 'add')
        $('#addGroupeModal').modal('show');
    @endif

    @if(session('modal') && str_starts_with(session('modal'), 'edit-'))
        $('#editGroupeModal{{ substr(session('modal'), 5) }}').modal('show');
    @endif

    // Animation pour la fermeture manuelle des alertes
    $('.alert .close').on('click', function() {
        $(this).parent('.alert').fadeOut('slow');
    });
});
</script>
@endpush
@endsection