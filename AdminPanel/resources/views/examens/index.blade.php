@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des examens</h1>
    
   
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Limite de temps (minutes)</th>
                <th>Limite d'affichage des questions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($examens as $examen)
            <tr>
                <!-- Change column names here -->
                <td>{{ $examen->titre }}</td> <!-- Correct column name for title -->
                <td>{{ $examen->description }}</td> <!-- Correct column name for description -->
                <td>{{ $examen->temps_limite }}</td> <!-- Correct column name for time limit -->
                <td>{{ $examen->question_limit }}</td> <!-- Correct column name for question limit -->
                <td>
                    <a href="{{ route('examens.manage', $examen->id) }}" class="btn btn-primary">Gérer</a>
                    <form method="POST" action="{{ route('examens.delete', $examen->id) }}" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Aucun examen trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('examens.create') }}" class="btn btn-success">Ajouter un nouvel examen</a>
</div>
@endsection