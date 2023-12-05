<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $home = 'home';

        if($user->hasRole('admin'))
        {
            // admin stuff
            $home = 'admin.home';
        }
        if($user->hasRole('user'))
        {
            // user stuff
            $home = 'user.home';
        }

        return view($home);
    }
}
