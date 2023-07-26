<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\agencie;
use App\Models\branche;
use App\Models\department;
use App\Models\role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function register()
    {
        return view('auth/register');
    }
}
