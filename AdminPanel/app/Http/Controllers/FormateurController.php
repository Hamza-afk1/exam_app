<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Cours;
use App\Models\Examen;
use App\Models\Stagiaire;
use App\Models\Groupe;
use Illuminate\Support\Facades\DB;

class FormateurController extends Controller
{
    public function dashboard()
    {
        try {
            // Get the logged-in formateur
            $formateur = Auth::guard('formateur')->user();
            
            if (!$formateur) {
                return redirect()->route('login');
            }

            // Get the groups IDs for this formateur
            $groupeIds = $formateur->groupes()->pluck('id')->toArray();

            // Get counts with proper queries
            $totalGroups = count($groupeIds);
            
            // Count students in formateur's groups
            $totalStudents = DB::table('stagiaires')
                ->whereIn('groupe_id', $groupeIds)
                ->count();

            // Count courses either created by formateur or assigned to their groups
            $totalCourses = DB::table('cours')
                ->where(function($query) use ($formateur, $groupeIds) {
                    $query->where('formateur_id', $formateur->id)
                          ->orWhereIn('groupe_id', $groupeIds);
                })
                ->count();

            // Count exams in formateur's groups
            $totalExams = DB::table('examens')
                ->whereIn('groupe_id', $groupeIds)
                ->count();

            // Debug log
            \Log::info('Formateur Dashboard Debug:', [
                'formateur_id' => $formateur->id,
                'groupe_ids' => $groupeIds,
                'raw_counts' => [
                    'groups' => $totalGroups,
                    'students' => $totalStudents,
                    'courses' => $totalCourses,
                    'exams' => $totalExams
                ]
            ]);

            return view('formateur.dashboard', compact(
                'formateur',
                'totalGroups',
                'totalStudents',
                'totalCourses',
                'totalExams'
            ));

        } catch (\Exception $e) {
            \Log::error('Formateur Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading dashboard data');
        }
    }

    public function profile()
    {
        $formateur = Auth::guard('formateur')->user();
        return view('formateur.profile', compact('formateur'));
    }

    public function updateProfile(Request $request)
    {
        $formateur = Auth::guard('formateur')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:formateurs,email,' . $formateur->id,
            'password' => 'nullable|min:6',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $formateur->name = $request->name;
        $formateur->email = $request->email;

        if ($request->filled('password')) {
            $formateur->password = Hash::make($request->password);
        }

        if ($request->hasFile('picture')) {
            if ($formateur->picture) {
                Storage::disk('public')->delete($formateur->picture);
            }

            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('formateur_pictures', $filename, 'public');
            $formateur->picture = $path;
        }

        $formateur->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}