<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Cours; // Correct import
use App\Models\Groupe;
use App\Models\Question; // Added import for Question
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    /**
     * Show the list of examens
     */
    public function index()
    {
        $examens = Examen::with('groupe')->get();
        return view('examens.index', compact('examens'));
    }

    /**
     * Show the form to create a new examen
     */
    public function create()
    {
        $groupes = Groupe::all();
        return view('examens.create', compact('groupes'));
    }

    /**
     * Store a newly created examen
     */
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

    /**
     * Show the form to edit the examen
     */
    public function edit($id)
    {
        $examen = Examen::findOrFail($id);
        $cours = Cours::all(); // Correct model usage
        return view('examens.edit', compact('examen', 'cours'));
    }

    /**
     * Update an examen
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
            'cou_id' => $validated['courseId'], // Ensure this column is correct in the database
            'ex_title' => $validated['examTitle'],
            'ex_description' => $validated['examDesc'],
            'ex_time_limit' => $validated['examLimit'],
            'ex_questlimit_display' => $validated['examQuestDipLimit']
        ]);

        return redirect()->route('examens.manage', $examen->id)
            ->with('success', 'Examen mis à jour avec succès');
    }

    /**
     * Delete an examen
     */
    public function destroy($id)
    {
        $examen = Examen::findOrFail($id);
        $examen->delete();

        return redirect()->route('examens.index')
            ->with('success', 'Examen supprimé avec succès');
    }

    /**
     * Manage an examen (questions, etc.)
     */
    public function manage($id)
    {
        // Fetch the examen with its course and questions
        $examen = Examen::with(['course', 'questions'])->findOrFail($id);
    
        // Fetch all courses to populate the dropdown
        $courses = Cours::all();
    
        return view('examens.manage', compact('examen', 'courses'));
    }
    

    /**
     * Add a question to the examen
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
        
        $examen->questions()->create([ // Assuming Examen has a `hasMany` relationship with Question
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
     * Update a question
     */
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

        // Mettre à jour la question
        $question->update([
            'exam_question' => $validatedData['exam_question'],
            'exam_answer' => $validatedData['exam_answer'],
            'choices' => $validatedData['choices'],
            'examen_id' => $validatedData['examen_id'],
        ]);

        return redirect()->route('examens.manage', $validatedData['examen_id'])
            ->with('success', 'Question mise à jour avec succès');
    }

    /**
     * Delete a question
     */
    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Question supprimée avec succès');
    }
}
