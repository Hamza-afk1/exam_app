<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('Admin.user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6', // Ajout de la validation du mot de passe
            'role' => 'required|in:admin,formateur,stagiaire',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashage du mot de passe
            'role' => strtolower($request->role)
        ];

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile-pictures', 'public');
            $userData['picture'] = $path;
        }

        User::create($userData);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6', // Password optionnel pour la mise à jour
            'role' => 'required|in:admin,formateur,stagiaire',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => strtolower($request->role)
        ];

        // Mise à jour du mot de passe uniquement si fourni
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Gestion de l'image de profil
        if ($request->hasFile('picture')) {
            // Suppression de l'ancienne image si elle existe
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            $path = $request->file('picture')->store('profile-pictures', 'public');
            $userData['picture'] = $path;
        }

        $user->update($userData);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Suppression de l'image de profil si elle existe
        if ($user->picture) {
            Storage::disk('public')->delete($user->picture);
        }
        
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}