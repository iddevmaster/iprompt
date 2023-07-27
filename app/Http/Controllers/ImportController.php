<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;


class ImportController extends Controller
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
        Alert::success('SuccessAlert','Lorem ipsum dolor sit amet.');
        return view('imported');
    }
}
