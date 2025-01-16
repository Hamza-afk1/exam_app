<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FormateurController extends Controller
{
    // Display a listing of the formateurs
    public function index()
    {
        $formateurs = Formateur::all(); // Fetch all formateurs
        return view('formateur.index', compact('formateurs')); // Pass data to the view
    }

    // Store a newly created formateur in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:formateurs,email',
            'password' => 'required|string|min:8', // Ensure password is required and has a minimum length
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $formateur = new Formateur();
        $formateur->name = $request->name;
        $formateur->prenom = $request->prenom;
        $formateur->email = $request->email;
        $formateur->role = 'formateur'; // Default role for formateur
        $formateur->password = Hash::make($request->password); // Hash the password

        // Handle file upload
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $formateur->picture = $path;
        }

        $formateur->save();

        return redirect()->route('formateur.index')->with('success', 'Formateur added successfully.');
    }

    // Show the form for editing the specified formateur
    public function edit($id)
    {
        $formateur = Formateur::findOrFail($id); // Find formateur by ID
        return view('formateur.edit', compact('formateur')); // Return edit view
    }

    // Update the specified formateur in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:formateurs,email,' . $id,
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $formateur = Formateur::findOrFail($id); // Find formateur by ID
        $formateur->name = $request->name;
        $formateur->prenom = $request->prenom;
        $formateur->email = $request->email;

        // Handle file upload
        if ($request->hasFile('picture')) {
            // Optionally delete the old picture if it exists
            if ($formateur->picture) {
                \Storage::disk('public')->delete($formateur->picture);
            }
            $path = $request->file('picture')->store('pictures', 'public');
            $formateur->picture = $path;
        }

        // If the password is provided, hash it and update
        if ($request->filled('password')) {
            $formateur->password = Hash::make($request->password);
        }

        $formateur->save();

        return redirect()->route('formateur.index')->with('success', 'Formateur updated successfully.');
    }

    // Remove the specified formateur from storage
    public function destroy($id)
    {
        $formateur = Formateur::findOrFail($id); // Find formateur by ID
        // Optionally delete the picture if it exists
        if ($formateur->picture) {
            \Storage::disk('public')->delete($formateur->picture);
        }
        $formateur->delete(); // Delete the formateur

        return redirect()->route('formateur.index')->with('success', 'Formateur deleted successfully.');
    }
}
