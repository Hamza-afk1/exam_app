@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Colonne de gauche pour gérer l'examen -->
        <div class="col-md-6">
            <h1>Gérer l'examen : {{ $examen->titre }}</h1>
            <form method="POST" action="{{ route('examens.update') }}">
                @csrf
                @method('PUT') <!-- Utilisez PUT pour la mise à jour -->
                <input type="hidden" name="examen_id" value="{{ $examen->id }}">

                <div class="form-group">
                    <label for="courseId">Cours</label>
                    <select id="courseId" name="courseId" class="form-control" required>
                        <option value="{{ $examen->cou_id }}">
                            {{ $examen->cours ? $examen->cours->titre : 'Aucun cours associé' }}
                        </option>
                        @foreach($cours as $course)
                            <option value="{{ $course->id }}">{{ $course->titre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="examTitle">Titre de l'examen</label>
                    <input type="text" id="examTitle" name="examTitle" class="form-control" required value="{{ $examen->titre }}">
                </div>

                <div class="form-group">
                    <label for="examDesc">Description de l'examen</label>
                    <input type="text" id="examDesc" name="examDesc" class="form-control" required value="{{ $examen->description }}">
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
                <form action="{{ route('examens.addQuestion') }}" method="POST" id="questionForm">
                    @csrf
                    <input type="hidden" name="examen_id" value="{{ $examen->id }}">
                    
                    <div id="questions-container">
                        <!-- Premier groupe de questions -->
                        <div class="question-group mb-4 border p-3">
                            <div class="form-group">
                                <label>Question</label>
                                <textarea name="exam_question[]" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Type de question</label>
                                <select name="question_type[]" class="form-control question-type-select" onchange="toggleQuestionType(this)">
                                    <option value="qcm">QCM</option>
                                    <option value="open">Question ouverte</option>
                                </select>
                            </div>

                            <div class="qcm-options">
                                <div class="choices-container">
                                    <div class="choice-group mb-2">
                                        <div class="input-group">
                                            <input type="text" name="choices[0][]" class="form-control" placeholder="Option 1">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="correct_answers[0][]" value="0"> Correct
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addChoice(this)">
                                    Ajouter une option
                                </button>
                            </div>

                            <div class="form-group">
                                <label>Points pour cette question</label>
                                <input type="number" name="points[]" class="form-control" required min="0" step="0.5" value="1">
                            </div>

                            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeQuestion(this)">
                                Supprimer cette question
                            </button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" onclick="addQuestion()">
                        Ajouter une autre question
                    </button>

                    <button type="submit" class="btn btn-primary">Enregistrer toutes les questions</button>
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
    // Afficher les messages de succès/erreur
    @if(Session::has('success'))
        alert("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        alert("{{ Session::get('error') }}");
    @endif

    let questionCount = 1;

    function addQuestion() {
        const container = document.getElementById('questions-container');
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-group mb-4 border p-3';
        
        questionDiv.innerHTML = `
            <div class="form-group">
                <label>Question</label>
                <textarea name="exam_question[]" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Type de question</label>
                <select name="question_type[]" class="form-control question-type-select" onchange="toggleQuestionType(this)">
                    <option value="qcm">QCM</option>
                    <option value="open">Question ouverte</option>
                </select>
            </div>

            <div class="qcm-options">
                <div class="choices-container">
                    <div class="choice-group mb-2">
                        <div class="input-group">
                            <input type="text" name="choices[${questionCount}][]" class="form-control" placeholder="Option 1">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <input type="checkbox" name="correct_answers[${questionCount}][]" value="0"> Correct
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addChoice(this)">
                    Ajouter une option
                </button>
            </div>

            <div class="form-group">
                <label>Points pour cette question</label>
                <input type="number" name="points[]" class="form-control" required min="0" step="0.5" value="1">
            </div>

            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeQuestion(this)">
                Supprimer cette question
            </button>
        `;
        
        container.appendChild(questionDiv);
        questionCount++;
    }

    function addChoice(button) {
        const choicesContainer = button.previousElementSibling;
        const questionGroup = button.closest('.question-group');
        const questionIndex = Array.from(questionGroup.parentNode.children).indexOf(questionGroup);
        const choiceCount = choicesContainer.children.length;
        
        const choiceDiv = document.createElement('div');
        choiceDiv.className = 'choice-group mb-2';
        choiceDiv.innerHTML = `
            <div class="input-group">
                <input type="text" name="choices[${questionIndex}][]" class="form-control" placeholder="Option ${choiceCount + 1}">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <input type="checkbox" name="correct_answers[${questionIndex}][]" value="${choiceCount}"> Correct
                    </div>
                    <button type="button" class="btn btn-danger" onclick="removeChoice(this)">×</button>
                </div>
            </div>
        `;
        
        choicesContainer.appendChild(choiceDiv);
    }

    function removeChoice(button) {
        button.closest('.choice-group').remove();
    }

    function removeQuestion(button) {
        button.closest('.question-group').remove();
    }

    function toggleQuestionType(select) {
        const questionGroup = select.closest('.question-group');
        const qcmOptions = questionGroup.querySelector('.qcm-options');
        
        if (select.value === 'qcm') {
            qcmOptions.style.display = 'block';
        } else {
            qcmOptions.style.display = 'none';
        }
    }
</script>

<style>
    .question-group {
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    
    .choice-group {
        position: relative;
    }
    
    .input-group-append .btn-danger {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endsection
