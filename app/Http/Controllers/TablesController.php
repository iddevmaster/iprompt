<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gendoc;
use App\Models\User;

class TablesController extends Controller
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
    public function index(Request $request)
    {
        
    }
    public function wiTable() {
        $gendoc = gendoc::where('type', 'wiForm')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/wiTable', compact('gendoc', 'user'));
    }

    public function sopTable() {
        $gendoc = gendoc::where('type', 'sopForm')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/sopTable', compact('gendoc', 'user'));
    }

    public function policyTable() {
        $gendoc = gendoc::where('type', 'policyForm')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/policyTable', compact('gendoc', 'user'));
    }
}
