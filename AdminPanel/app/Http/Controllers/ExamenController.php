<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;
use App\Models\Question;
use App\Models\Course;
use App\Models\Groupe; // Importez le modèle Groupe

class ExamenController extends Controller
{
    // Affiche le formulaire de création d'un examen
    public function create()
    {
        $groupes = Groupe::all(); // Récupérer tous les groupes
        return view('examens.create', compact('groupes'));
    }

    // Affiche la liste des examens
    public function index()
    {
        $examens = Examen::all();
        return view('examens.index', compact('examens'));
    }
    public function destroy($id)
{
    $examen = Examen::findOrFail($id);
    $examen->delete();
    return redirect()->route('examens.index')->with('success', 'Examen deleted successfully.');
}

    // Gère un examen spécifique
    public function manage($id)
    {
        $examen = Examen::with('questions')->findOrFail($id);
        $courses = Course::all();
        $questions = Question::all();

        return view('examens.manage', compact('examen', 'courses'));
    }

    // Stocke un nouvel examen
    public function store(Request $request)
    {
        // Valider les données entrantes
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'groupe_id' => 'required|exists:groupes,id',
            'description' => 'nullable|string',
            'temps_limite' => 'required|integer|min:1',
            'question_limit' => 'required|integer|min:1',
        ]);
        
        // Créer un nouvel examen
        $examen = Examen::create($validatedData);

        // Rediriger avec un message de succès
        return redirect()->route('examens.index')->with('success', 'Examen créé avec succès !');
    }

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
    }

    // Rediriger avec un message de succès
    return redirect()->route('examens.show', $examenId)->with('success', 'Les questions ont été ajoutées avec succès.');
}

}