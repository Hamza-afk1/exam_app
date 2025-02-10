@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Créer un nouvel examen</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('examens.store') }}">
                @csrf
                
                {{-- Titre --}}
                <div class="form-group">
                    <label for="examTitle">Titre de l'examen</label>
                    <input type="text" 
                           class="form-control @error('examTitle') is-invalid @enderror" 
                           id="examTitle" 
                           name="examTitle" 
                           value="{{ old('examTitle') }}" 
                           required>
                    @error('examTitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                {{-- Groupe --}}
                <div class="form-group">
                    <label for="groupe_id">Groupe</label>
                    <select class="form-control @error('groupe_id') is-invalid @enderror" 
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
                    <label for="examDesc">Description</label>
                    <textarea class="form-control @error('examDesc') is-invalid @enderror" 
                              id="examDesc" 
                              name="examDesc" 
                              rows="3" 
                              required>{{ old('examDesc') }}</textarea>
                    @error('examDesc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                {{-- Temps limite --}}
                <div class="form-group">
                    <label for="examLimit">Temps limite (minutes)</label>
                    <input type="number" 
                           class="form-control @error('examLimit') is-invalid @enderror" 
                           id="examLimit" 
                           name="examLimit" 
                           value="{{ old('examLimit') }}" 
                           min="1" 
                           required>
                    @error('examLimit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                {{-- Nombre de questions --}}
                <div class="form-group">
                    <label for="examQuestDipLimit">Nombre de questions</label>
                    <input type="number" 
                           class="form-control @error('examQuestDipLimit') is-invalid @enderror" 
                           id="examQuestDipLimit" 
                           name="examQuestDipLimit" 
                           value="{{ old('examQuestDipLimit') }}" 
                           min="1" 
                           required>
                    @error('examQuestDipLimit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Créer l'examen</button>
                    <a href="{{ route('examens.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection