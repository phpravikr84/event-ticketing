<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on the user's role.
     */
    public function index()
    {
        $user = Auth::user();

        // Determine the user's role and redirect to the appropriate dashboard
        switch ($user->role->name) {
            case 'admin':
                return view('administrator.dashboard.admin');
            
            case 'attendee':
                return view('administrator.dashboard.attendee');
            
            case 'organizer':
                return view('administrator.dashboard.organizer');
            
            default:
                return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
    }
}
