<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StagiaireController extends Controller
{
    // Display a listing of the stagiaires
    public function index()
    {
        $stagiaires = Stagiaire::all(); // Fetch all stagiaires
        return view('stagiaire.index', compact('stagiaires')); // Pass data to the view
    }

    // Store a newly created stagiaire in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'groupe' => 'required|string|max:255',
            'email' => 'required|email|unique:stagiaires,email',
            'password' => 'required|string|min:8', // Ensure password is required and has a minimum length
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $stagiaire = new Stagiaire();
        $stagiaire->name = $request->name;
        $stagiaire->prenom = $request->prenom;
        $stagiaire->groupe = $request->groupe;
        $stagiaire->email = $request->email;
        $stagiaire->password = Hash::make($request->password); // Hash the password

        // Handle file upload
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $stagiaire->picture = $path;
        }

        $stagiaire->save();

        return redirect()->route('stagiaire.index')->with('success', 'Stagiaire added successfully.');
    }

    // Show the form for editing the specified stagiaire
    public function edit($id)
    {
        $stagiaire = Stagiaire::findOrFail($id); // Find stagiaire by ID
        return view('stagiaire.edit', compact('stagiaire')); // Return edit view
    }

    // Update the specified stagiaire in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'groupe' => 'required|string|max:255',
            'email' => 'required|email|unique:stagiaires,email,' . $id,
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $stagiaire = Stagiaire::findOrFail($id); // Find stagiaire by ID
        $stagiaire->name = $request->name;
        $stagiaire->prenom = $request->prenom;
        $stagiaire->groupe = $request->groupe;
        $stagiaire->email = $request->email;

        // Handle file upload
        if ($request->hasFile('picture')) {
            // Optionally delete the old picture if it exists
            if ($stagiaire->picture) {
                \Storage::disk('public')->delete($stagiaire->picture);
            }
            $path = $request->file('picture')->store('pictures', 'public');
            $stagiaire->picture = $path;
        }

        // If the password is provided, hash it and update
        if ($request->filled('password')) {
            $stagiaire->password = Hash::make($request->password);
        }

        $stagiaire->save();

        return redirect()->route('stagiaire.index')->with('success', 'Stagiaire updated successfully.');
    }

    // Remove the specified stagiaire from storage
    public function destroy($id)
    {
        $stagiaire = Stagiaire::findOrFail($id); // Find stagiaire by ID
        // Optionally delete the picture if it exists
        if ($stagiaire->picture) {
            \Storage::disk('public')->delete($stagiaire->picture);
        }
        $stagiaire->delete(); // Delete the stagiaire

        return redirect()->route('stagiaire.index')->with('success', 'Stagiaire deleted successfully.');
    }
}