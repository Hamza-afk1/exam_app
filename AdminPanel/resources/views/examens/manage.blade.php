@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        
        <div class="row">
            <!-- Colonne de gauche pour gérer l'examen -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Gérer l'examen : {{ $examen->ex_title }}</h4>
                        <form method="POST" action="{{ route('examens.update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="examen_id" value="{{ $examen->id }}">

                            <div class="form-group">
                                <label for="courseId">Cours</label>
                                <select id="courseId" name="courseId" class="form-control" required>
                                    <option value="{{ $examen->cou_id }}">
                                        {{ $examen->course ? $examen->course->cou_name : 'Aucun cours associé' }}
                                    </option>
                                    @foreach($cours as $course)
                                        <option value="{{ $course->id }}">{{ $course->titre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="examTitle">Titre de l'examen</label>
                                <input type="text" id="examTitle" name="examTitle" class="form-control" required value="{{ $examen->ex_title }}">
                            </div>

                            <div class="form-group">
                                <label for="examDesc">Description</label>
                                <textarea id="examDesc" name="examDesc" class="form-control" rows="3" required>{{ $examen->ex_description }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examLimit">Durée (minutes)</label>
                                        <select id="examLimit" name="examLimit" class="form-control" required>
                                            @foreach([10, 20, 30, 40, 50, 60] as $minutes)
                                                <option value="{{ $minutes }}" {{ $examen->ex_time_limit == $minutes ? 'selected' : '' }}>
                                                    {{ $minutes }} Minutes
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examQuestDipLimit">Nombre de questions</label>
                                        <input type="number" id="examQuestDipLimit" name="examQuestDipLimit" 
                                               class="form-control" min="1" value="{{ $examen->ex_questlimit_display }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-gradient-primary btn-lg btn-block">
                                <i class="fas fa-save"></i> Mettre à jour l'examen
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite pour les questions -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Questions de l'examen</h4>
                            <button class="btn btn-gradient-primary" data-toggle="modal" data-target="#modalForAddQuestion">
                                <i class="fas fa-plus"></i> Ajouter une question
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>Type</th>
                                        <th>Points</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($examen->questions as $question)
                                        <tr>
                                            <td>{{ $question->exam_question }}</td>
                                            <td>
                                                <span class="badge badge-gradient-info">QCM</span>
                                            </td>
                                            <td>{{ $question->points ?? 1 }}</td>
                                            <td>
                                                <button onclick="openModiferModel({{$question->id}})" 
                                                        class="btn btn-gradient-warning btn-sm"
                                                        data-toggle="modal" 
                                                        data-target="#modalForUpdateQuestion">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" 
                                                      action="{{ route('examens.deleteQuestion', $question->id) }}" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="btn btn-gradient-danger btn-sm"
                                                            onclick="confirmDelete(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="alert alert-info mb-0">
                                                    <i class="fas fa-info-circle mr-2"></i>
                                                    Aucune question ajoutée pour cet examen
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

<!-- Modal Ajout Question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">Ajouter une question</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('examens.addQuestion') }}" id="addQuestionForm">
                    @csrf
                    <input type="hidden" name="examen_id" value="{{ $examen->id }}">

                    <div class="form-group">
                        <label>Type de Question</label>
                        <select class="form-control" name="question_type" id="questionType">
                            <option value="qcm">QCM (Choix multiples)</option>
                            <option value="ouverte">Question ouverte</option>
                            <option value="vrai_faux">Vrai/Faux</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Question</label>
                        <textarea name="exam_question" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Points</label>
                        <input type="number" name="points" class="form-control" value="1" min="0.5" step="0.5">
                    </div>

                    <!-- Options QCM -->
                    <div id="qcmOptions">
                        <div class="form-group">
                            <label>Options de réponse</label>
                            <div id="optionsContainer">
                                @foreach(['A', 'B', 'C', 'D'] as $option)
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" name="correct_answers[]" value="{{ $option }}">
                                            </div>
                                        </div>
                                        <input type="text" name="exam_ch{{ $loop->iteration }}" 
                                               class="form-control" placeholder="Option {{ $option }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Question Ouverte -->
                    <div id="ouverteOptions" style="display: none;">
                        <div class="form-group">
                            <label>Réponse suggérée</label>
                            <textarea name="reponse_suggeree" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Vrai/Faux -->
                    <div id="vraiFauxOptions" style="display: none;">
                        <div class="form-group">
                            <label>Réponse correcte</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="vrai_faux" value="vrai" class="custom-control-input" id="vrai">
                                <label class="custom-control-label" for="vrai">Vrai</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="vrai_faux" value="faux" class="custom-control-input" id="faux">
                                <label class="custom-control-label" for="faux">Faux</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modification Question -->
<div class="modal fade" id="modalForUpdateQuestion" tabindex="-1">
    <!-- Structure similaire au modal d'ajout -->
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion du type de question
    $('#questionType').change(function() {
        const type = $(this).val();
        $('#qcmOptions, #ouverteOptions, #vraiFauxOptions').hide();
        
        switch(type) {
            case 'qcm':
                $('#qcmOptions').show();
                break;
            case 'ouverte':
                $('#ouverteOptions').show();
                break;
            case 'vrai_faux':
                $('#vraiFauxOptions').show();
                break;
        }
    });

    // Validation du formulaire
    $('#addQuestionForm').submit(function(e) {
        const type = $('#questionType').val();
        if (type === 'qcm') {
            const checkedAnswers = $('input[name="correct_answers[]"]:checked').length;
            if (checkedAnswers === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner au moins une réponse correcte');
            }
        }
    });
});

function openModiferModel(questionId) {
    // Logique pour charger les données de la question
    $('#question_id').val(questionId);
}

function confirmDelete(button) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette question ?')) {
        button.closest('form').submit();
    }
}
</script>
@endpush

@push('styles')
<style>
<style>
/* Couleurs principales */
:root {
    --primary-gradient: linear-gradient(to right, #da8cff, #9a55ff);
    --success-gradient: linear-gradient(to right, #84d9d2, #07cdae);
    --warning-gradient: linear-gradient(to right, #f6e384, #ffd500);
    --danger-gradient: linear-gradient(to right, #ffbf96, #fe7096);
    --info-gradient: linear-gradient(to right, #90caf9, #047edf);
}

/* Cards */
.card {
    border: none;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
}

.card-title {
    color: #3e4b5b;
    font-weight: 500;
}

/* Boutons */
.btn-gradient-primary {
    background: var(--primary-gradient);
    border: 0;
    transition: all 0.3s ease;
}

.btn-gradient-primary:hover {
    background: linear-gradient(to right, #9a55ff, #da8cff);
    box-shadow: 0 5px 15px rgba(154, 85, 255, 0.4);
}

/* Badges */
.badge {
    padding: 0.5em 1em;
    border-radius: 0.25rem;
    font-weight: 500;
    font-size: 12px;
}

.badge-gradient-info {
    background: var(--info-gradient);
    color: white;
}

/* Table */
.table {
    margin-bottom: 0;
}

.table thead th {
    border-top: 0;
    font-weight: 500;
    font-size: 0.875rem;
    color: #3e4b5b;
}

.table td {
    vertical-align: middle;
    color: #444;
    font-size: 0.875rem;
    border-color: #ebedf2;
}

/* Modal */
.modal-content {
    border: none;
    border-radius: 0.5rem;
}

.modal-header.bg-gradient-primary {
    background: var(--primary-gradient);
    border-radius: 0.5rem 0.5rem 0 0;
    padding: 1rem 1.5rem;
}

.modal-header .close {
    color: white;
    text-shadow: none;
    opacity: 0.8;
}

.modal-header .close:hover {
    opacity: 1;
}

/* Form Controls */
.form-control {
    border: 1px solid #ebedf2;
    font-size: 0.875rem;
    border-radius: 0.25rem;
    padding: 0.625rem 0.875rem;
    transition: border-color 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #9a55ff;
    box-shadow: none;
}

/* Input Groups */
.input-group-text {
    background-color: #f8f9fa;
    border-color: #ebedf2;
    color: #3e4b5b;
}

/* Custom Checkboxes */
.custom-control-input:checked ~ .custom-control-label::before {
    background: var(--primary-gradient);
    border-color: #9a55ff;
}

/* Action Buttons */
.btn-gradient-warning {
    background: var(--warning-gradient);
    border: 0;
    color: #fff;
}

.btn-gradient-danger {
    background: var(--danger-gradient);
    border: 0;
    color: #fff;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.812rem;
}

/* Alerts */
.alert-info {
    background-color: rgba(144, 202, 249, 0.2);
    border-color: rgba(144, 202, 249, 0.3);
    color: #047edf;
}

/* Textarea */
textarea.form-control {
    min-height: 100px;
}

/* Select */
select.form-control {
    appearance: none;
    -webkit-appearance: none;
    background: #fff url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
    background-size: 8px 10px;
    padding-right: 1.75rem;
}

/* Points Input */
input[type="number"] {
    width: 100px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .table-responsive {
        border: 0;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    
    .modal-dialog {
        margin: 0.5rem;
    }
}

/* Hover Effects */
.table-hover tbody tr:hover {
    background-color: rgba(154, 85, 255, 0.05);
}

.btn:focus {
    box-shadow: none;
}

/* Question Options */
#optionsContainer .input-group,
#updateOptionsContainer .input-group {
    margin-bottom: 0.75rem;
}

.input-group-text input[type="checkbox"] {
    margin: 0;
}

/* Card Header Actions */
.card-header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Custom Radio Buttons */
.custom-radio .custom-control-input:checked ~ .custom-control-label::before {
    background: var(--primary-gradient);
}

/* Loading States */
.btn.loading {
    position: relative;
    pointer-events: none;
    opacity: 0.8;
}

.btn.loading::after {
    content: '';
    position: absolute;
    width: 1rem;
    height: 1rem;
    border: 2px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endpush
@endsection