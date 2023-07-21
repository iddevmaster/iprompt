<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gendoc;
use App\Models\User;
use App\Models\project_doc;
use App\Models\announce_doc;
use App\Models\mou_doc;

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

    // query all wi form from database to wi table page
    public function wiTable() {
        $gendoc = gendoc::where('type', 'wiForm')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/wiTable', compact('gendoc', 'user'));
    }

    // query all sop form from database to sop table page
    public function sopTable() {
        $gendoc = gendoc::where('type', 'sopForm')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/sopTable', compact('gendoc', 'user'));
    }

    // query all policy form from database to policy table page
    public function policyTable() {
        $gendoc = gendoc::where('type', 'policyForm')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/policyTable', compact('gendoc', 'user'));
    }

    // query all mou form from database to mou table page
    public function mouTable() {
        $gendoc = mou_doc::all();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/mouTable', compact('gendoc', 'user'));
    }

    // query all project form from database to project table page
    public function projTable() {
        $gendoc = project_doc::all();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/projTable', compact('gendoc', 'user'));
    }

    // query all anno form from database to anno table page
    public function annoTable() {
        $gendoc = announce_doc::all();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/annoTable', compact('gendoc', 'user'));
    }

}
