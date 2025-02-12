@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Correction de l'examen : {{ $examen->titre }}</h2>

    @foreach($examen->questions as $question)
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Question {{ $loop->iteration }}</h5>
                <span class="badge badge-primary">{{ $question->points }} points</span>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $question->exam_question }}</p>

            @if($question->question_type === 'qcm')
                <!-- Affichage des réponses QCM -->
                <div class="qcm-correction">
                    @foreach($question->choices as $choice)
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   disabled 
                                   {{ $choice->is_correct ? 'checked' : '' }}>
                            <label class="form-check-label {{ $choice->is_correct ? 'text-success font-weight-bold' : '' }}">
                                {{ $choice->choice_text }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Formulaire de correction pour les questions ouvertes -->
                <form action="{{ route('examens.correctQuestion', $question->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="form-group">
                        <label>Note attribuée (max: {{ $question->points }} points)</label>
                        <input type="number" 
                               name="awarded_points" 
                               class="form-control" 
                               min="0" 
                               max="{{ $question->points }}" 
                               step="0.5" 
                               value="{{ $question->awarded_points ?? 0 }}" 
                               required>
                    </div>
                    <div class="form-group">
                        <label>Commentaire de correction</label>
                        <textarea name="correction_comment" 
                                  class="form-control" 
                                  rows="2">{{ $question->correction_comment ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer la correction</button>
                </form>
            @endif
        </div>
    </div>
    @endforeach

    <div class="card mt-4">
        <div class="card-body">
            <h5>Résumé de la correction</h5>
            <p>Total des points : {{ $examen->questions->sum('points') }}</p>
            <p>Points attribués : {{ $examen->questions->sum('awarded_points') ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection 