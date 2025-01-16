@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un Examen</h1>

    {{-- Formulaire pour créer un examen --}}
    <form method="POST" action="{{ route('examens.store') }}">
        @csrf {{-- Protection contre les attaques CSRF --}}
        
        {{-- Titre --}}
        <div class="form-group">
            <label for="titre">Titre</label>
            <input 
                type="text" 
                class="form-control @error('titre') is-invalid @enderror" 
                id="titre" 
                name="titre" 
                value="{{ old('titre') }}" 
                required>
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Groupe --}}
        <div class="form-group">
            <label for="groupe_id">Groupe</label>
            <select 
                class="form-control @error('groupe_id') is-invalid @enderror" 
                id="groupe_id" 
                name="groupe_id" 
                required>
                <option value="" disabled selected>-- Sélectionnez un groupe --</option>
                @foreach($groupes as $groupe)
                    <option value="{{ $groupe->id }}" {{ old('groupe_id') == $groupe->id ? 'selected' : '' }}>
                        {{ $groupe->nom }}
                    </option>
                @endforeach
            </select>
            @error('groupe_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="description">Description</label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                id="description" 
                name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Temps Limite --}}
        <div class="form-group">
            <label for="temps_limite">Temps Limite (en minutes)</label>
            <input 
                type="number" 
                class="form-control @error('temps_limite') is-invalid @enderror" 
                id="temps_limite" 
                name="temps_limite" 
                value="{{ old('temps_limite') }}" 
                required>
            @error('temps_limite')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Limite de Questions --}}
        <div class="form-group">
            <label for="question_limit">Nombre de Questions Affichées</label>
            <input 
                type="number" 
                class="form-control @error('question_limit') is-invalid @enderror" 
                id="question_limit" 
                name="question_limit" 
                value="{{ old('question_limit') }}" 
                required>
            @error('question_limit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bouton de soumission --}}
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
