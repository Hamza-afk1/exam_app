<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Stagiaire;  // Ajoutez cette ligne
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function index()
    {
        $groupes = Groupe::all();
        foreach($groupes as $groupe) {
            $groupe->stagiaires_count = Stagiaire::where('groupe', $groupe->nom)->count();
        }
        return view('groupes.index', compact('groupes'));
    }
    public function store(Request $request)
    {
        try {
            // Vérifier d'abord si le groupe existe déjà
            $existingGroupe = Groupe::where('nom', $request->nom)->first();
            if ($existingGroupe) {
                return redirect()->route('groupes.index')
                    ->with('error', 'Le groupe "' . $request->nom . '" existe déjà !');
            }
    
            // Si le groupe n'existe pas, le créer
            $validated = $request->validate([
                'nom' => 'required|string|max:255|unique:groupes,nom',
            ]);
    
            $groupe = Groupe::create($validated);
            return redirect()->route('groupes.index')
                ->with('success', 'Groupe créé avec succès');
    
        } catch (\Exception $e) {
            return redirect()->route('groupes.index')
                ->with('error', 'Erreur lors de la création du groupe');
        }
    }
    
    public function show($id)
{
    $groupe = Groupe::findOrFail($id);
    $stagiaires = Stagiaire::where('groupe', $groupe->nom)->get();
    
    return view('groupes.show', compact('groupe', 'stagiaires'));
}
    public function update(Request $request, $id)
{
    try {
        $groupe = Groupe::findOrFail($id);
        
        // Vérifier si le nouveau nom existe déjà pour un autre groupe
        $existingGroupe = Groupe::where('nom', $request->nom)
            ->where('id', '!=', $id)
            ->first();
            
        if ($existingGroupe) {
            return redirect()->route('groupes.index')
                ->with('error', 'Le groupe "' . $request->nom . '" existe déjà !');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:groupes,nom,'.$id,
        ]);

        $groupe->update($validated);
        return redirect()->route('groupes.index')
            ->with('success', 'Groupe mis à jour avec succès');

    } catch (\Exception $e) {
        return redirect()->route('groupes.index')
            ->with('error', 'Erreur lors de la modification du groupe');
    }
}
    public function destroy($id)
    {
        try {
            $groupe = Groupe::findOrFail($id);
            
            // Mettre à null les références dans les examens
            \DB::table('examens')->where('groupe_id', $id)->update(['groupe_id' => null]);
            
            // Mettre à null le groupe pour les stagiaires
            \DB::table('stagiaires')->where('groupe', $groupe->nom)->update(['groupe' => null]);
            
            // Maintenant on peut supprimer le groupe
            $groupe->delete();
    
            return redirect()->route('groupes.index')
                ->with('success', 'Groupe supprimé avec succès');
                
        } catch (\Exception $e) {
            return redirect()->route('groupes.index')
                ->with('error', 'Impossible de supprimer ce groupe. Il est peut-être utilisé ailleurs.');
        }
    }
}