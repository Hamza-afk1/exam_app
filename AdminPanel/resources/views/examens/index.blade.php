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

    <!-- Conteneur pour permettre un défilement horizontal -->
  
        <table class="table table-bordered" style="width: 100%; table-layout: fixed; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 5px; text-align: center;">Titre</th>
                    <th style="padding: 5px; text-align: center;">Description</th>
                    <th style="padding: 5px; text-align: center;">Limite de temps (minutes)</th>
                    <th style="padding: 5px; text-align: center;">Limite d'affichage des questions</th>
                    <th style="padding: 5px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($examens as $examen)
                <tr>
                    <!-- Limiter la largeur des colonnes -->
                    <td style="padding: 5px; text-align: center; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $examen->titre }}
                    </td>
                    <td style="padding: 5px; text-align: center; word-wrap: break-word; max-width: 300px;">
                        {{ Str::limit($examen->description, 50) }}
                    </td>
                    <td style="padding: 5px; text-align: center;">{{ $examen->temps_limite }}</td>
                    <td style="padding: 5px; text-align: center;">{{ $examen->question_limit }}</td>
                    <td style="padding: 5px; text-align: center;">
                        <a href="{{ route('examens.manage', $examen->id) }}" class="btn btn-primary btn-sm">Gérer</a>
                        <form method="POST" action="{{ route('examens.delete', $examen->id) }}" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 5px; text-align: center;">Aucun examen trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
 

    <a href="{{ route('examens.create') }}" class="btn btn-success btn-sm" style="margin-top: 10px;">Ajouter un nouvel examen</a>
</div>
@endsection
