<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::all();
        return view('cours.index', compact('cours'));
    }

    public function store(Request $request)
    {
        \Log::info('Données reçues:', $request->all());  
        try {
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
            ]);
    
            $cours = Cours::create([
                'titre' => $validated['titre'],
                'description' => $validated['description']
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Cours créé avec succès',
                'cours' => $cours
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du cours: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du cours: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $cours = Cours::findOrFail($id);
        $cours->update($validated);

        return redirect()->route('cours.index')
            ->with('success', 'Cours mis à jour avec succès');
    }

    public function destroy($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->delete();

        return redirect()->route('cours.index')
            ->with('success', 'Cours supprimé avec succès');
    }
}