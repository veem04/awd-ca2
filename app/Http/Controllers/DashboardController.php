<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        // returns a different view depending on if the user is an admin
        if ($user->hasRole('admin'))
        {
            return view('admin.dashboard');
        }
        else {
            return view('dashboard');
        }
    }
}
