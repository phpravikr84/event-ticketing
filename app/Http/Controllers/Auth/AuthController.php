<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;
use Session;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login submission.
     */
    public function login(Request $request): RedirectResponse
    {
        // Validate input fields
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        try {
            // Attempt to authenticate with provided credentials
            if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
                // Regenerate session to prevent session fixation
                $request->session()->regenerate();

                // Get the authenticated user
                $user = Auth::user();
                
                // Log user role
                \Log::info('User role: ' . $user->role->name);

                // // Ensure the user has a role
                // if (!$user->role) {
                //     Auth::logout();
                //     return redirect()->route('login')->with('error', 'Your account does not have a valid role.');
                // }

                // Log the user role and handle redirection
                \Log::info('Switching role: ' . $user->role->name);
            
            
                return redirect()->route('administrator.dashboard.organizer');
                exit;
            
                //dd($user->role->name);

                // Redirect based on role
                switch ($user->role->name) {
                    case 'admin':
                        return redirect()->route('administrator.dashboard.admin');
                    
                    case 'attendee':
                        return redirect()->route('administrator.dashboard.attendee');
                    
                    case 'organizer':
                        return redirect()->route('administrator.dashboard.organizer');
                    
                    default:
                        Auth::logout();
                        return redirect()->route('login')->with('error', 'Unauthorized role.');
                }
            }

            // If authentication fails, return back with an error
            return back()->withErrors([
                'credentials' => 'Invalid email or password.',
            ])->withInput(); // Retain input except the password
        } catch (\Exception $e) {
            // Catch any errors that may occur during authentication
            \Log::error('Login error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during login. Please try again later.');
        }
    }




    /**
     * Show the registration form.
     */
    public function showRegister(): View
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle registration submission.
     */
    public function register(Request $request): RedirectResponse
    {
        // Validate input fields
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,id',  // Ensure role exists in roles table
        ]);

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $validatedData['role'],  // Ensure the role_id is valid
        ]);

        // Log the user in immediately after registration
        Auth::login($user);

        // Regenerate the session to prevent session fixation
        $request->session()->regenerate();

        // Redirect to the appropriate dashboard based on user role
        switch ($user->role->name) {
            case 'admin':
                return redirect()->route('administrator.dashboard.admin')->with('success', 'Registration successful! You are now logged in as Admin.');
            
            case 'attendee':
                return redirect()->route('administrator.dashboard.attendee')->with('success', 'Registration successful! You are now logged in as Attendee.');
            
            case 'organizer':
                return redirect()->route('administrator.dashboard.organizer')->with('success', 'Registration successful! You are now logged in as Organizer.');
            
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Unauthorized role.');
        }
    }


    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
