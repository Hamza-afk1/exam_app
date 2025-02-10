@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card" style="margin-left: 0.5rem; margin-right: 2rem;">
                <div class="card-body px-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Liste des Examens</h4>
                        <a href="{{ route('examens.create') }}" class="btn btn-inverse-success">
                            <i class="fas fa-plus me-2"></i>Ajouter un Examen
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 22%">Titre</th>
                                    <th style="width: 15%">Groupe</th>
                                    <th style="width: 25%">Description</th>
                                    <th style="width: 13%">Temps limite</th>
                                    <th style="width: 15%">Questions</th>
                                    <th style="width: 10%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($examens as $examen)
                                <tr>
                                    <td>{{ $examen->titre }}</td>
                                    <td>
                                        <label class="badge badge-gradient-success">
                                            {{ $examen->groupe ? $examen->groupe->nom : 'Non assigné' }}
                                        </label>
                                    </td>
                                    <td>{{ Str::limit($examen->description, 30) }}</td>
                                    <td>
                                        <label class="badge badge-gradient-info">
                                            {{ $examen->temps_limite }} minutes
                                        </label>
                                    </td>
                                    <td>
                                        <label class="badge badge-gradient-warning">
                                            {{ $examen->question_limit }} questions
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center">
                                            <a href="{{ route('examens.manage', $examen->id) }}" 
                                               class="btn btn-sm btn-outline-secondary mr-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('examens.destroy', $examen->id) }}" 
                                                  method="POST" 
                                                  class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?')">
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

@push('styles')
<style>
    .badge {
        padding: 0.5em 1em;
        font-size: 12px;
    }
    .badge-gradient-success {
        background: linear-gradient(to right, #84d9d2, #07cdae);
        color: white;
    }
    .badge-gradient-info {
        background: linear-gradient(to right, #90caf9, #047edf);
        color: white;
    }
    .badge-gradient-warning {
        background: linear-gradient(to right, #f6e384, #ffd500);
        color: #000;
    }
    .btn-inverse-success {
        background-color: rgba(0, 198, 137, 0.2);
        background-image: none;
        border-color: rgba(0, 198, 137, 0);
        color: #00c689;
    }
    .btn-inverse-success:hover {
        background-color: rgba(0, 198, 137, 0.3);
        color: #00c689;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .btn-outline-danger:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(154, 85, 255, 0.1);
    }
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #ebedf2;
    }
    .mr-1 {
        margin-right: 0.5rem !important;
    }
    .me-2 {
        margin-right: 0.5rem;
    }
    .card-title {
        margin-bottom: 0;
        font-size: 1.25rem;
        font-weight: 500;
    }
    .table thead th {
        border-top: 0;
        font-weight: 500;
        font-size: 0.875rem;
    }
    .delete-form {
        display: inline-block;
        margin: 0;
        padding: 0;
    }
    .d-inline-flex {
        display: inline-flex !important;
    }
    .align-items-center {
        align-items: center !important;
    }
    .content-wrapper {
        padding: 1.5rem 1rem 1.5rem 0.5rem;
    }
    .grid-margin {
        margin-left: auto;
        margin-right: auto;
    }
    .table th, .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }
    .table td:nth-child(3) {
        max-width: 200px;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .card-body {
        padding: 1.5rem 1rem;
        overflow-x: hidden;
    }
    .table-responsive {
        margin: 0;
        padding: 0;
    }
</style>
@endpush
@endsection