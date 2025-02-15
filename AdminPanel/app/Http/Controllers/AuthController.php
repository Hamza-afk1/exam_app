<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Formateur;
use App\Models\Stagiaire;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check in Admin table
        $admin = Admin::where('email', $credentials['email'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->put('LoggedUserRole', 'admin');
            return redirect()->route('admin.dashboard');
        }

        // Check in Formateur table
        $formateur = Formateur::where('email', $credentials['email'])->first();
        if ($formateur && Hash::check($credentials['password'], $formateur->password)) {
            Auth::guard('formateur')->login($formateur);
            $request->session()->put('LoggedUserRole', 'formateur');
            return redirect()->route('formateur.dashboard');
        }

        // Check in Stagiaire table
        $stagiaire = Stagiaire::where('email', $credentials['email'])->first();
        if ($stagiaire && Hash::check($credentials['password'], $stagiaire->password)) {
            Auth::guard('stagiaire')->login($stagiaire);
            $request->session()->put('LoggedUserRole', 'stagiaire');
            return redirect()->route('stagiaire.dashboard');
        }

        return back()->withErrors([
            'email' => 'Ces identifiants ne correspondent à aucun compte.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        $role = session('LoggedUserRole');
        
        switch($role) {
            case 'admin':
                Auth::guard('admin')->logout();
                break;
            case 'formateur':
                Auth::guard('formateur')->logout();
                break;
            case 'stagiaire':
                Auth::guard('stagiaire')->logout();
                break;
        }
        
        $request->session()->forget('LoggedUserRole');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}