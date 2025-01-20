@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Colonne de gauche pour gérer l'examen -->
        <div class="col-md-6">
            <h1>Gérer l'examen : {{ $examen->ex_title }}</h1>
            <form method="POST" action="{{ route('examens.update', $examen->id) }}">
                @csrf
                @method('PUT') <!-- Utilisez PUT pour la mise à jour -->
                <input type="hidden" name="examId" value="{{ $examen->id }}">


                
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
                            {{ $question->exam_question }}
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalForUpdateQuestion" data-id="{{ $question->id }}" data-question="{{ $question->exam_question }}" data-answer="{{ $question->exam_answer }}" data-choice-a="{{ $question->exam_ch1 }}" data-choice-b="{{ $question->exam_ch2 }}" data-choice-c="{{ $question->exam_ch3 }}" data-choice-d="{{ $question->exam_ch4 }}">Modifier</button>
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
<div class="modal fade " id="modalForAddQuestion" tabindex="-1" role="dialog" aria-labelledby="modalForAddQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalForAddQuestionLabel">Ajouter une question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('examens.addQuestion', $examen->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="examQuestion">Question</label>
                        <input type="text" id="examQuestion" name="examQuestion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="examAnswer">Réponse correcte</label>
                        <input type="text" id="examAnswer" name="examAnswer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="examChoiceA">Choix A</label>
                        <input type="text" id="examChoiceA" name="examChoiceA" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="examChoiceB">Choix B</label>
                        <input type="text" id="examChoiceB" name="examChoiceB" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="examChoiceC">Choix C</label>
                        <input type="text" id="examChoiceC" name="examChoiceC" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="examChoiceD">Choix D</label>
                        <input type="text" id="examChoiceD" name="examChoiceD" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter la question</button>
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
                    <input type="hidden" id="updateQuestionId" name="questionId">
                    <div class="form-group">
                        <label for="updateExamQuestion">Question</label>
                        <input type="text" id="updateExamQuestion" name="examQuestion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateExamAnswer">Réponse correcte</label>
                        <input type="text" id="updateExamAnswer" name="examAnswer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateExamChoiceA">Choix A</label>
                        <input type="text" id="updateExamChoiceA" name="examChoiceA" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateExamChoiceB">Choix B</label>
                        <input type="text" id="updateExamChoiceB" name="examChoiceB" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateExamChoiceC">Choix C</label>
                        <input type="text" id="updateExamChoiceC" name="examChoiceC" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="updateExamChoiceD">Choix D</label>
                        <input type="text" id="updateExamChoiceD" name="examChoiceD " class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour la question</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modalForUpdateQuestion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
        var questionId = button.data('id');
        var questionText = button.data('question');
        var answerText = button.data('answer');
        var choiceA = button.data('choice-a');
        var choiceB = button.data('choice-b');
        var choiceC = button.data('choice-c');
        var choiceD = button.data('choice-d');

        var modal = $(this);
        modal.find('#updateQuestionId').val(questionId);
        modal.find('#updateExamQuestion').val(questionText);
        modal.find('#updateExamAnswer').val(answerText);
        modal.find('#updateExamChoiceA').val(choiceA);
        modal.find('#updateExamChoiceB').val(choiceB);
        modal.find('#updateExamChoiceC').val(choiceC);
        modal.find('#updateExamChoiceD').val(choiceD);
    });
</script>
@endsection