<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gendoc;
use App\Models\User;
use App\Models\project_doc;
use App\Models\announce_doc;
use App\Models\mou_doc;
use PDF;

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
        $gendoc = gendoc::where('type', 'wiForm')->orderBy('id', 'desc')->get();
        $user = User::all();
        return view('/tables/wiTable', compact('gendoc', 'user'));
    }

    // query all sop form from database to sop table page
    public function sopTable() {
        $gendoc = gendoc::where('type', 'sopForm')->orderBy('id', 'desc')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/sopTable', compact('gendoc', 'user'));
    }

    // query all policy form from database to policy table page
    public function policyTable() {
        $gendoc = gendoc::where('type', 'policyForm')->orderBy('id', 'desc')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/policyTable', compact('gendoc', 'user'));
    }

    // query all mou form from database to mou table page
    public function mouTable() {
        $gendoc = mou_doc::orderBy('id', 'desc')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/mouTable', compact('gendoc', 'user'));
    }

    // query all project form from database to project table page
    public function projTable() {
        $gendoc = project_doc::orderBy('id', 'desc')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/projTable', compact('gendoc', 'user'));
    }

    // query all anno form from database to anno table page
    public function annoTable() {
        $gendoc = announce_doc::orderBy('id', 'desc')->get();
        $user = User::all();
        // dd($gendoc);
        return view('/tables/annoTable', compact('gendoc', 'user'));
    }

    public function createPDF() {
        // retreive all records from db
        $data = gendoc::all()->toArray();
        // share data to view
        view()->share('gendoc',$data);
        $pdf = PDF::loadView('pdf_export', $data);
        // download PDF file with download method
        return $pdf->stream('pdf_file.pdf');
    }
    // public function viewBeforDownload(Request $request,$id)
    // {
    //     $form = Form::find($id);
    //     $pdf = PDF::loadView('export.form.pdfform', compact('form'));
    //     return $pdf->stream('preview.pdf'); // Stream the PDF to the browser
    // }


}
