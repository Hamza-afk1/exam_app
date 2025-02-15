<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Admin;
use App\Models\User;
use App\Models\Formateur;
use App\Models\Stagiaire;
use App\Models\Groupe;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function showRegister()
    {
        return view('admin.register');
    }
    
    public function showLogin()
    {
        return view('admin.Login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.login')
            ->with('success', 'Registration successful. Please login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:12',
        ]);
    
        $adminInfo = Admin::where('email', $request->input('email'))->first();
    
        if (!$adminInfo) {
            return back()->withInput()->withErrors(['email' => 'Email not found']);
        }
    
        if (!Hash::check($request->input('password'), $adminInfo->password)) {
            return back()->withInput()->withErrors(['password' => 'Incorrect password']);
        }
    
        $request->session()->put('LoggedAdminInfo', $adminInfo->id);
    
        return redirect()->route('admin.dashboard');
    }

    public function showDashboard()
    {
        try {
            $totalFormateurs = DB::table('formateurs')->count();
            $totalStagiaires = DB::table('stagiaires')->count();
            $totalUsers = DB::table('users')->count();
            $totalGroups = DB::table('groupes')->count();

            \Log::info('Dashboard counts:', [
                'formateurs' => $totalFormateurs,
                'stagiaires' => $totalStagiaires,
                'users' => $totalUsers,
                'groups' => $totalGroups
            ]);

            return view('Admin.dashboard', [
                'LoggedAdminInfo' => session('LoggedAdminInfo'),
                'totalFormateurs' => $totalFormateurs,
                'totalStagiaires' => $totalStagiaires,
                'totalUsers' => $totalUsers,
                'totalGroups' => $totalGroups
            ]);

        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading dashboard data');
        }
    }

    public function showProfile(Request $request)
    {
        $LoggedAdminInfo = Admin::find(session('LoggedAdminInfo'));
    
        if (!$LoggedAdminInfo) {
            return redirect()->route('admin.login')
                ->with('fail', 'You must be logged in to access the profile page');
        }
    
        return view('admin.profile', ['LoggedAdminInfo' => $LoggedAdminInfo]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $admin = Admin::find(session('LoggedAdminInfo'));
    
        if (!$admin) {
            return redirect()->route('admin.login')
                ->with('fail', 'You must be logged in to update the profile');
        }
    
        $admin->name = $request->input('name');
        $admin->bio = $request->input('bio');
    
        if ($request->hasFile('picture')) {
            if ($admin->picture) {
                Storage::disk('public')->delete($admin->picture);
            }
    
            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            
            $admin->picture = $path;
        }
    
        $admin->save();
    
        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully');
    }
    
    public function logout(Request $request)
    {
        $request->session()->flush();
        session()->forget('LoggedAdminInfo');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')
            ->with('success', 'Logged out successfully');
    }
         
    public function showUserList()
    {
        $users = User::all();
        $LoggedAdminInfo = Admin::find(session('LoggedAdminInfo'));

        if (!$LoggedAdminInfo) {
            return redirect()->route('admin.login')
                ->with('fail', 'You must be logged in to access the profile page');
        }
    
        return view('admin.user', [
            'LoggedAdminInfo' => $LoggedAdminInfo,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
    
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $user->picture = $path;
        }
    
        $user->save();
    
        return redirect()->route('admin.user')
            ->with('success', 'User created successfully.');
    }
     
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6',
            'role' => 'required|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
 
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
 
        if ($request->hasFile('picture')) {
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            
            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $user->picture = $path;
        }

        $user->save();
 
        return redirect()->route('admin.user')
            ->with('success', 'User updated successfully.');
    }
 
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->picture) {
            Storage::disk('public')->delete($user->picture);
        }
        
        $user->delete();
 
        return redirect()->route('admin.user')
            ->with('success', 'User deleted successfully.');
    }
}