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
    public function updateQuestion(Request $request )
    {

        $validatedData = $request->validate([
            'question_id'    => 'required|exists:questions,id',
            'exam_question'  => 'required|string',
            'exam_answer'    => 'required|string',
            'exam_ch1'       => 'required|string',
            'exam_ch2'       => 'required|string',
            'exam_ch3'       => 'required|string',
            'exam_ch4'       => 'required|string', // This matches the form and table
            'examen_id'      => 'required|exists:examens,id',
        ]);
        

        // Trouver la question par ID et mettre à jour
        $question = Question::findOrFail($validatedData['question_id']);

        $question->update($validatedData);
        return redirect()->back()->with('success', 'Question mise à jour avec succès.');
    }

    // Ajoute une nouvelle question à un examen
    public function addQuestion(Request $request)
    {

        $validatedData = $request->validate([
            'exam_question' => 'required|string',
            'exam_answer' => 'required|string',
            'exam_ch1' => 'required|string',
            'exam_ch2' => 'required|string',
            'exam_ch3' => 'required|string',
            'exam_ch4' => 'required|string',
            'examen_id' => 'required|exists:examens,id',
        ]);

        // Créer une nouvelle question
        $question =  Question::create($validatedData);

        return redirect()->back()->with('success', 'Question ajoutée avec succès.');
    }
}