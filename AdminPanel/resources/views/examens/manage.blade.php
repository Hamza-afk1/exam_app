@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Colonne de gauche pour gérer l'examen -->
        <div class="col-md-6">
            <h1>Gérer l'examen : {{ $examen->ex_title }}</h1>
            <form method="POST" action="{{ route('examens.update') }}">
                @csrf
                @method('PUT') <!-- Utilisez PUT pour la mise à jour -->
                <input type="hidden" name="examen_id" value="{{ $examen->id }}">

                <div class="form-group">
                    <label for="courseId">Cours</label>
                    <select id="courseId" name="courseId" class="form-control" required>
                        <option value="{{ $examen->cou_id }}">
                            {{ $examen->course ? $examen->course->cou_name : 'Aucun cours associé' }}
                        </option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->cou_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="examTitle">Titre de l'examen</label>
                    <input type="text" id="examTitle" name="examTitle" class="form-control" required value="{{ $examen->ex_title }}">
                </div>

                <div class="form-group">
                    <label for="examDesc">Description de l'examen</label>
                    <input type="text" id="examDesc" name="examDesc" class="form-control" required value="{{ $examen->ex_description }}">
                </div>

                <div class="form-group">
                    <label for="examLimit">Limite de temps (en minutes)</label>
                    <select id="examLimit" name="examLimit" class="form-control" required>
                        <option value="{{ $examen->ex_time_limit }}">{{ $examen->ex_time_limit }} Minutes</option>
                        <option value="10">10 Minutes</option>
                        <option value="20">20 Minutes</option>
                        <option value="30">30 Minutes</option>
                        <option value="40">40 Minutes</option>
                        <option value="50">50 Minutes</option>
                        <option value="60">60 Minutes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="examQuestDipLimit">Limite d'affichage des questions</label>
                    <input type="number" id="examQuestDipLimit" name="examQuestDipLimit" class="form-control" value="{{ $examen->ex_questlimit_display }}">
                </div>

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
                            </button>
                            <form method="POST" action="{{ route('examens.deleteQuestion', $question->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter une question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1" role="dialog" aria-labelledby="modalForAddQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalForAddQuestionLabel">Ajouter une question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('examens.addQuestion') }}">
                    @csrf
                    <input type="hidden" name="examen_id" value="{{ $examen->id }}">

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
                </form>
            </div>
        </div>
    </div>
</div>

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
</div>

<script>
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
