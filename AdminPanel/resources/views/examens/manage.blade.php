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

<<<<<<< HEAD
                <button type="submit" class="btn btn-primary btn-lg">Mettre à jour</button>
            </form>
        </div>

        <!-- Colonne de droite pour afficher les questions -->
        <div class="col-md-6">
            <h2>Questions</h2>
            <div class="card">
                <div class="card-header">
                    <span>Questions associées à l'examen</span>
                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modalForAddQuestion">Ajouter une question</button>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($examen->questions as $question)
                        <li class="list-group-item">
                            {{ $question->exam_question }} {{$question->id}}
                            @if($question->question_type === 'open')
                                <p><strong>Réponse attendue:</strong> {{ $question->open_answer }}</p>
                            @else
                                <p><strong>Réponse correcte:</strong> {{ $question->exam_answer }}</p>
                                <p><strong>Choix:</strong>
                                    A) {{ $question->exam_ch1 }},
                                    B) {{ $question->exam_ch2 }},
                                    C) {{ $question->exam_ch3 }},
                                    D) {{ $question->exam_ch4 }}
                                </p>
                            @endif
                            <button onclick="openModiferModel({{$question->id}})" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalForUpdateQuestion" data-id="{{ $question->id }}" data-question="{{ $question->exam_question }}" data-answer="{{ $question->exam_answer }}" data-choice-a="{{ $question->exam_ch1 }}" data-choice-b="{{ $question->exam_ch2 }}" data-choice-c="{{ $question->exam_ch3 }}" data-choice-d="{{ $question->exam_ch4 }}" data-question-type="{{ $question->question_type }}" data-open-answer="{{ $question->open_answer }}">
                                Modifier
=======
                            <button type="submit" class="btn btn-gradient-primary btn-lg btn-block">
                                <i class="fas fa-save"></i> Mettre à jour l'examen
>>>>>>> 72886d81088b6ce778e795cf54a83f4a5deb6bab
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

<<<<<<< HEAD
<!-- Modal pour ajouter une question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1" role="dialog" aria-labelledby="modalForAddQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
=======
<!-- Modal Ajout Question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1">
    <div class="modal-dialog modal-lg">
>>>>>>> 72886d81088b6ce778e795cf54a83f4a5deb6bab
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

<<<<<<< HEAD
                    <div id="questionsContainer">
                        <!-- Conteneur pour les questions -->
                        <div class="question-group">
                            <div class="form-group">
                                <label for="questionType">Type de question</label>
                                <select name="question_type[]" class="form-control question-type" required onchange="toggleQuestionType(this)">
                                    <option value="qcm">QCM</option>
                                    <option value="open">Question ouverte</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="examQuestion">Question</label>
                                <input type="text" name="exam_question[]" class="form-control" required>
                            </div>

                            <!-- Champs pour QCM -->
                            <div class="qcm-fields">
                                <div class="qcm-choices">
                                    <div class="form-group qcm-choice">
                                        <label>Choix 1</label>
                                        <div class="input-group">
                                            <input type="text" name="exam_ch[0][]" class="form-control" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="correct_answer[0][]" value="0"> Correct
                                                </div>
                                            </div>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeQcmChoice(this)">Supprimer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="addQcmChoice(this)">Ajouter un choix</button>
                            </div>

                            <!-- Champ pour question ouverte -->
                            <div class="open-question-field" style="display: none;">
                                <div class="form-group">
                                    <label>Réponse attendue</label>
                                    <textarea name="open_answer[]" class="form-control"></textarea>
                                </div>
                            </div>

                            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeQuestion(this)">Supprimer cette question</button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-secondary mt-3" onclick="addQuestion()">Ajouter une autre question</button>
                    <button type="submit" class="btn btn-primary mt-3">Ajouter les questions</button>
=======
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
>>>>>>> 72886d81088b6ce778e795cf54a83f4a5deb6bab
                </form>
            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
<!-- Modal pour mettre à jour une question -->
<div class="modal fade" id="modalForUpdateQuestion" tabindex="-1" role="dialog" aria-labelledby="modalForUpdateQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalForUpdateQuestionLabel">Modifier la question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('examens.updateQuestion') }}">
                    @csrf
                    @method('put')
                    <input type="hidden" id="question_id" name="question_id" value="">

                    <div class="form-group">
                        <label for="updateQuestionType">Type de question</label>
                        <select id="updateQuestionType" name="question_type" class="form-control" required onchange="toggleUpdateQuestionType()">
                            <option value="qcm">QCM</option>
                            <option value="open">Question ouverte</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="updateExamQuestion">Question</label>
                        <input type="text" id="updateExamQuestion" name="exam_question" class="form-control" required>
                    </div>

                    <!-- Champs pour QCM -->
                    <div id="updateQcmFields">
                        <div id="updateQcmChoices">
                            <!-- Les choix seront ajoutés dynamiquement ici -->
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addUpdateQcmChoice()">Ajouter un choix</button>
                    </div>

                    <!-- Champ pour question ouverte -->
                    <div id="updateOpenQuestionField" style="display: none;">
                        <div id="updateOpenQuestions">
                            <!-- Les questions ouvertes seront ajoutées dynamiquement ici -->
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addUpdateOpenQuestion()">Ajouter une autre question</button>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour la question</button>
                </form>
            </div>
        </div>
    </div>
=======
<!-- Modal Modification Question -->
<div class="modal fade" id="modalForUpdateQuestion" tabindex="-1">
    <!-- Structure similaire au modal d'ajout -->
>>>>>>> 72886d81088b6ce778e795cf54a83f4a5deb6bab
</div>

@push('scripts')
<script>
<<<<<<< HEAD
    // Fonction pour ajouter une nouvelle question
    let questionCount = 1;

    function addQuestion() {
        const questionsContainer = document.getElementById('questionsContainer');
        
        // Créer une nouvelle question
        const newQuestion = document.createElement('div');
        newQuestion.classList.add('question-group');
        
        // Ajouter la question selon le type de la question précédente (ou un type par défaut)
        const questionType = 'qcm'; // Par défaut 'qcm'
        newQuestion.innerHTML = `
            <div class="form-group">
                <label for="questionType">Type de question</label>
                <select name="question_type[]" class="form-control question-type" required onchange="toggleQuestionType(this)">
                    <option value="qcm" ${questionType === 'qcm' ? 'selected' : ''}>QCM</option>
                    <option value="open" ${questionType === 'open' ? 'selected' : ''}>Question ouverte</option>
                </select>
            </div>

            <div class="form-group">
                <label for="examQuestion">Question</label>
                <input type="text" name="exam_question[]" class="form-control" required>
            </div>

            <!-- Champs pour QCM -->
            <div class="qcm-fields" style="${questionType === 'qcm' ? '' : 'display: none;'}">
                <div class="qcm-choices">
                    <div class="form-group qcm-choice">
                        <label>Choix 1</label>
                        <div class="input-group">
                            <input type="text" name="exam_ch[${questionCount}][]" class="form-control" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <input type="checkbox" name="correct_answer[${questionCount}][]" value="0"> Correct
                                </div>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeQcmChoice(this)">Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addQcmChoice(this)">Ajouter un choix</button>
            </div>

            <!-- Champ pour question ouverte -->
            <div class="open-question-field" style="${questionType === 'open' ? '' : 'display: none;'}">
                <div class="form-group">
                    <label>Réponse attendue</label>
                    <textarea name="open_answer[]" class="form-control"></textarea>
                </div>
            </div>

            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeQuestion(this)">Supprimer cette question</button>
        `;
        
        // Ajouter la nouvelle question au conteneur
        questionsContainer.appendChild(newQuestion);
        questionCount++;
    }


    // Fonction pour ajouter un choix QCM
    function addQcmChoice(button) {
        const qcmChoices = button.closest('.qcm-fields').querySelector('.qcm-choices');
        const choiceCount = qcmChoices.querySelectorAll('.qcm-choice').length;
        const newChoice = document.createElement('div');
        newChoice.classList.add('form-group', 'qcm-choice');
        newChoice.innerHTML = `
            <label>Choix ${choiceCount + 1}</label>
            <div class="input-group">
                <input type="text" name="exam_ch[${questionCount - 1}][]" class="form-control" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <input type="checkbox" name="correct_answer[${questionCount - 1}][]" value="${choiceCount}"> Correct
                    </div>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeQcmChoice(this)">Supprimer</button>
                </div>
            </div>
        `;
        qcmChoices.appendChild(newChoice);
    }

    // Fonction pour supprimer un choix QCM
    function removeQcmChoice(button) {
        const choiceDiv = button.closest('.qcm-choice');
        choiceDiv.remove();
    }

    // Fonction pour supprimer une question
    function removeQuestion(button) {
        const questionDiv = button.closest('.question-group');
        questionDiv.remove();
    }

    // Fonction pour basculer entre QCM et question ouverte
    function toggleQuestionType(select) {
        const questionDiv = select.closest('.question-group');
        const questionType = select.value;
        const qcmFields = questionDiv.querySelector('.qcm-fields');
        const openQuestionField = questionDiv.querySelector('.open-question-field');
        qcmFields.style.display = (questionType === 'qcm' ? '' : 'none');
        openQuestionField.style.display = (questionType === 'open' ? '' : 'none');
    }
</script>
@endsection
=======
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
>>>>>>> 72886d81088b6ce778e795cf54a83f4a5deb6bab
