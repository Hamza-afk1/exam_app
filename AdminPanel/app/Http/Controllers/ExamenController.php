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
            'questionId' => 'required|exists:exam_question_tbl,id', // Assurez-vous que la table est correcte
            'examQuestion' => 'required|string',
            'examAnswer' => 'required|string',
            'examChoiceA' => 'required|string',
            'examChoiceB' => 'required|string',
            'examChoiceC' => 'required|string',
            'examChoiceD' => 'required|string',
        ]);

        // Trouver la question par ID et mettre à jour
        $question = Question::findOrFail($validatedData['questionId']);
        $question->exam_question = $validatedData['examQuestion'];
        $question->exam_answer = $validatedData['examAnswer'];
        $question->exam_ch1 = $validatedData['examChoiceA'];
        $question->exam_ch2 = $validatedData['examChoiceB'];
        $question->exam_ch3 = $validatedData['examChoiceC'];
        $question->exam_ch4 = $validatedData['examChoiceD'];
        $question->save();

        return redirect()->back()->with('success', 'Question mise à jour avec succès.');
    }

    // Ajoute une nouvelle question à un examen
    public function addQuestion(Request $request, $examenId)
    {
        $validatedData = $request->validate([
            'examQuestion' => 'required|string',
            'examAnswer' => 'required|string',
            'examChoiceA' => 'required|string',
            'examChoiceB' => 'required|string',
            'examChoiceC' => 'required|string',
            'examChoiceD' => 'required|string',
        ]);

        // Créer une nouvelle question
        $question = new Question();
        $question->exam_question = $validatedData['examQuestion'];
        $question->exam_answer = $validatedData['examAnswer'];
        $question->exam_ch1 = $validatedData['examChoiceA'];
        $question->exam_ch2 = $validatedData['examChoiceB'];
        $question->exam_ch3 = $validatedData['examChoiceC'];
        $question->exam_ch4 = $validatedData['examChoiceD'];
        $question->exam_id = $examenId; // Assurez-vous que vous avez une colonne pour l'ID de l'examen
        $question->save();

        return redirect()->back()->with('success', 'Question ajoutée avec succès.');
    }
}