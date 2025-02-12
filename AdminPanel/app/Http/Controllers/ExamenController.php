<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Cours;
use App\Models\Groupe;
use App\Models\Question; // Added import for Question
use App\Models\QuestionChoice; // Added import for QuestionChoice
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    /**
     * Show the list of examens
     */
    public function index()
    {
        $examens = Examen::all();
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
     * Gérer un examen (questions, etc.)
     */
    public function manage($id)
    {
        try {
            // Récupérer l'examen avec ses relations
            $examen = Examen::with(['questions.choices'])->findOrFail($id);
            $cours = Cours::all();  // Si vous avez besoin des cours
            
            // Pour le débogage
            \Log::info('Examen trouvé:', ['id' => $id, 'titre' => $examen->titre]);
            
            return view('examens.manage', compact('examen', 'cours'));
        } catch (\Exception $e) {
            \Log::error('Erreur dans manage:', ['error' => $e->getMessage()]);
            return redirect()->route('examens.index')
                            ->with('error', 'Examen non trouvé ou erreur: ' . $e->getMessage());
        }
    }
    

    /**
     * Add a question to the examen
     */
    public function addQuestion(Request $request)
    {
        try {
            $request->validate([
                'examen_id' => 'required|exists:examens,id',
                'exam_question' => 'required|array',
                'exam_question.*' => 'required|string',
                'question_type' => 'required|array',
                'question_type.*' => 'required|in:qcm,open',
                'points' => 'required|array',
                'points.*' => 'required|numeric|min:0'
            ]);

            foreach ($request->exam_question as $key => $questionText) {
                $question = Question::create([
                    'examen_id' => $request->examen_id,
                    'exam_question' => $questionText,
                    'question_type' => $request->question_type[$key],
                    'points' => $request->points[$key]
                ]);

                if ($request->question_type[$key] === 'qcm' && isset($request->choices[$key])) {
                    foreach ($request->choices[$key] as $choiceIndex => $choiceText) {
                        if (!empty($choiceText)) {
                            QuestionChoice::create([
                                'question_id' => $question->id,
                                'choice_text' => $choiceText,
                                'is_correct' => in_array(
                                    (string)$choiceIndex, 
                                    $request->correct_answers[$key] ?? []
                                )
                            ]);
                        }
                    }
                }
            }

            return redirect()
                ->route('examens.manage', ['id' => $request->examen_id])
                ->with('success', 'Questions ajoutées avec succès');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'ajout des questions: ' . $e->getMessage());
        }
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

    public function correction($id)
    {
        $examen = Examen::with(['questions.choices'])->findOrFail($id);
        return view('examens.correction', compact('examen'));
    }

    public function correctQuestion(Request $request, $id)
    {
        $request->validate([
            'awarded_points' => 'required|numeric|min:0',
            'correction_comment' => 'nullable|string'
        ]);

        $question = Question::findOrFail($id);
        
        // Vérifier que les points attribués ne dépassent pas le maximum
        if ($request->awarded_points > $question->points) {
            return redirect()->back()->with('error', 'Les points attribués ne peuvent pas dépasser le maximum');
        }

        $question->update([
            'awarded_points' => $request->awarded_points,
            'correction_comment' => $request->correction_comment
        ]);

        return redirect()->back()->with('success', 'Correction enregistrée');
    }

    public function correctionsList()
    {
        $examens = Examen::with('questions')->get();
        return view('examens.corrections-list', compact('examens'));
    }
}
