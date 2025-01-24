@extends('layouts.app')

@section('title', 'Détails du Groupe')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon shadow-sm bg-gradient-primary text-white me-3 ">
                    <i class="fas fa-users"></i>
                </span> 
                Détails du Groupe : {{ $groupe->nom }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('groupes.index') }}">Groupes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Détails</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-0">Liste des Stagiaires</h4>
                                <p class="text-muted">Total : {{ $stagiaires->count() }} stagiaires</p>
                            </div>
                            <a href="{{ route('groupes.index') }}" class="btn btn-gradient-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                        </div>

                        <!-- Barre de recherche -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-primary text-white">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <input type="text" 
                                               class="form-control" 
                                               id="searchStagiaire" 
                                               placeholder="Rechercher un stagiaire...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table des stagiaires -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Email</th>
                                        <th>Groupe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stagiaires as $stagiaire)
                                        <tr class="stagiaire-row">
                                            <td>
                                                @if($stagiaire->picture)
                                                    <img src="{{ asset('storage/' . $stagiaire->picture) }}" 
                                                         alt="Profile" 
                                                         class="rounded-circle"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/images/faces/default.jpg') }}" 
                                                         alt="Default Profile"
                                                         class="rounded-circle"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                            </td>
                                            <td>{{ $stagiaire->name }}</td>
                                            <td>{{ $stagiaire->prenom }}</td>
                                            <td>{{ $stagiaire->email }}</td>
                                            <td>
                                                <span class="badge badge-gradient-success">
                                                    {{ $stagiaire->groupe }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="alert alert-info mb-0">
                                                    <i class="fas fa-info-circle mr-2"></i>
                                                    Aucun stagiaire dans ce groupe
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
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

@push('styles')
<style>
    .badge-gradient-success {
        background: linear-gradient(to right, #84d9d2, #07cdae);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.075);
    }
    .breadcrumb {
        background: transparent;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Réinitialiser la sidebar
    $('.sidebar .nav-item').removeClass('active');
    $('.sidebar .nav-link').removeClass('active');
    $('.sidebar .collapse').removeClass('show');
    $('.sidebar .nav-link').attr('aria-expanded', 'false');
    
    // Activer uniquement le menu Groupes
    $('.nav-item:has(a[href*="groupes"])').addClass('active');

    // Fonction de recherche
    $("#searchStagiaire").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".stagiaire-row").filter(function() {
            var nom = $(this).find("td:eq(1)").text().toLowerCase();
            var prenom = $(this).find("td:eq(2)").text().toLowerCase();
            var searchText = nom + " " + prenom;
            $(this).toggle(searchText.indexOf(value) > -1);
        });
    });

    // Animation pour les messages d'alerte
    $('.alert').fadeIn('slow').delay(4000).fadeOut('slow');
});
</script>
@endpush