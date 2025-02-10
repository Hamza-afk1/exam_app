<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Cours;
use App\Models\Groupe;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    
    public function index()
{
    $examens = Examen::with('groupe')->get();
    return view('examens.index', compact('examens'));
}
    public function create()
    {
        $groupes = Groupe::all();
        return view('examens.create', compact('groupes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'examTitle' => 'required|string|max:255',
            'groupe_id' => 'required|exists:groupes,id',
            'examDesc' => 'required|string',
            'examLimit' => 'required|integer|min:1',
            'examQuestDipLimit' => 'required|integer|min:1'
        ]);

        $examen = Examen::create([
            'titre' => $validated['examTitle'],
            'groupe_id' => $validated['groupe_id'],
            'description' => $validated['examDesc'],
            'temps_limite' => $validated['examLimit'],
            'question_limit' => $validated['examQuestDipLimit']
        ]);

        return redirect()->route('examens.index')
            ->with('success', 'Examen créé avec succès');
    }

<<<<<<< HEAD
    // Met à jour une question existante
    public function updateQuestion(Request $request)
{
    $validatedData = $request->validate([
        'question_id'    => 'required|exists:questions,id',
        'exam_question'  => 'required|string',
        'exam_answer'    => 'required|string',
        'choices' => 'required_if:question_type,qcm|array', // Liste des choix pour qcm
        'choices.*' => 'required|string', // Chaque choix doit être une chaîne
        'examen_id'      => 'required|exists:examens,id',
    ]);

    // Trouver la question par ID
    $question = Question::findOrFail($validatedData['question_id']);
    $question->update($validatedData);

    if ($question->question_type === 'qcm') {
        // Supprimer les anciens choix
        $question->choices()->delete();

        // Ajouter les nouveaux choix
        foreach ($request->choices as $index => $choice_text) {
            $is_correct = ($index == 0);  // Par exemple, le premier choix est correct
            $question->choices()->create([
                'choice_text' => $choice_text,
                'is_correct' => $is_correct, // Marquer le premier choix comme correct
            ]);
        }
    }

    return redirect()->back()->with('success', 'Question mise à jour avec succès.');
}


    // Ajoute une nouvelle question à un examen
    public function addQuestion(Request $request)
{
    // Validation des données envoyées
    $validated = $request->validate([
        'examen_id' => 'required|exists:examens,id',
        'question_type' => 'required|array',
        'question' => 'required|array',  // Modification ici si la colonne est 'question' dans la base
        'exam_ch' => 'array', // Pour les choix QCM
        'correct_answer' => 'array', // Pour les bonnes réponses QCM
        'open_answer' => 'array', // Pour les questions ouvertes
    ]);

    // Enregistrer les questions
    foreach ($validated['question'] as $index => $question) {  // Modification ici si la colonne est 'question'
        $questionType = $validated['question_type'][$index];
        $examenId = $validated['examen_id'];

        // Créer la question
        $newQuestion = new Question();
        $newQuestion->examen_id = $examenId;
        $newQuestion->question = $question;  // Modification ici si la colonne est 'question'
        $newQuestion->type = $questionType;
        
        if ($questionType === 'qcm') {
            // Si c'est une question QCM, enregistrer les choix et les réponses
            $newQuestion->save(); // Sauvegarder la question QCM

            foreach ($validated['exam_ch'][$index] as $choiceIndex => $choice) {
                $newChoice = new Choice();
                $newChoice->question_id = $newQuestion->id;
                $newChoice->choice_text = $choice;
                $newChoice->is_correct = in_array($choiceIndex, $validated['correct_answer'][$index]) ? true : false;
                $newChoice->save();
            }
        } else {
            // Si c'est une question ouverte, enregistrer la réponse attendue
            $newQuestion->save(); // Sauvegarder la question ouverte
            $newQuestion->open_answer = $validated['open_answer'][$index];
            $newQuestion->save();
        }
=======
    public function edit($id)
    {
        $examen = Examen::findOrFail($id);
        $cours = Course::all();
        return view('examens.edit', compact('examen', 'cours'));
    }

    /**
     * Mettre à jour un examen
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'examen_id' => 'required|exists:examens,id',
            'courseId' => 'required|exists:courses,id',
            'examTitle' => 'required|string|max:255',
            'examDesc' => 'required|string',
            'examLimit' => 'required|integer|min:1',
            'examQuestDipLimit' => 'required|integer|min:1'
        ]);

        $examen = Examen::findOrFail($validated['examen_id']);
        
        $examen->update([
            'cou_id' => $validated['courseId'],
            'ex_title' => $validated['examTitle'],
            'ex_description' => $validated['examDesc'],
            'ex_time_limit' => $validated['examLimit'],
            'ex_questlimit_display' => $validated['examQuestDipLimit']
        ]);

        return redirect()->route('examens.manage', $examen->id)
            ->with('success', 'Examen mis à jour avec succès');
    }

    /**
     * Supprimer un examen
     */
    public function destroy($id)
    {
        $examen = Examen::findOrFail($id);
        $examen->delete();

        return redirect()->route('examens.index')
            ->with('success', 'Examen supprimé avec succès');
    }

    /**
     * Gérer un examen (questions, etc.)
     */
    public function manage($id)
    {
        $examen = Examen::with(['course', 'questions'])->findOrFail($id);
        $cours = Course::all();
        return view('examens.manage', compact('examen', 'cours'));
    }

    /**
     * Ajouter une question à l'examen
     */
    public function addQuestion(Request $request)
    {
        $validated = $request->validate([
            'examen_id' => 'required|exists:examens,id',
            'exam_question' => 'required|string',
            'exam_answer' => 'required|string',
            'exam_ch1' => 'required|string',
            'exam_ch2' => 'required|string',
            'exam_ch3' => 'required|string',
            'exam_ch4' => 'required|string',
        ]);

        $examen = Examen::findOrFail($validated['examen_id']);
        
        $examen->questions()->create([
            'exam_question' => $validated['exam_question'],
            'exam_answer' => $validated['exam_answer'],
            'exam_ch1' => $validated['exam_ch1'],
            'exam_ch2' => $validated['exam_ch2'],
            'exam_ch3' => $validated['exam_ch3'],
            'exam_ch4' => $validated['exam_ch4'],
        ]);

        return redirect()->route('examens.manage', $examen->id)
            ->with('success', 'Question ajoutée avec succès');
    }

    /**
     * Mettre à jour une question
     */
    public function updateQuestion(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:exam_questions,id',
            'exam_question' => 'required|string',
            'exam_answer' => 'required|string',
            'exam_ch1' => 'required|string',
            'exam_ch2' => 'required|string',
            'exam_ch3' => 'required|string',
            'exam_ch4' => 'required|string',
        ]);

        $question = ExamQuestion::findOrFail($validated['question_id']);
        $question->update($validated);

        return redirect()->back()->with('success', 'Question mise à jour avec succès');
    }

    /**
     * Supprimer une question
     */
    public function deleteQuestion($id)
    {
        $question = ExamQuestion::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Question supprimée avec succès');
>>>>>>> 72886d81088b6ce778e795cf54a83f4a5deb6bab
    }

    // Rediriger avec un message de succès
    return redirect()->route('examens.show', $examenId)->with('success', 'Les questions ont été ajoutées avec succès.');
}

}