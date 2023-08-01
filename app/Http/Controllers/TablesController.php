<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gendoc;
use App\Models\User;
use App\Models\project_doc;
use App\Models\announce_doc;
use App\Models\mou_doc;
use App\Models\imported;
use PDF;
Use Alert;

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

    public function viewwi(Request $request,$id) {

        $form = gendoc::find($id);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $parties = [];


        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        return view('/forms/'.$formtype, compact( 'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    public function viewsop(Request $request,$id) {

        $form = gendoc::find($id);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $parties = [];


        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        return view('/forms/'.$formtype, compact( 'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    public function viewpolicy(Request $request,$id) {

        $form = gendoc::find($id);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $parties = [];


        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        return view('/forms/'.$formtype, compact( 'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    public function viewanno(Request $request,$id) 
    {
        $form = announce_doc::find($id);
        $class = 1;
        $formtype = $form->type;
        $editorContent = $form->detail;
        $annNo = $form->book_num;
        $subject = $form->title;
        $annoDate = $form->anno_date;
        $useDate = $form->use_date;
        $signName = $form->sign_name;
        $signPosition = $form->sign_position;
        return view('/forms/'.$formtype, compact( 'annNo','signName', 'signPosition','annoDate', 'useDate', 'editorContent','subject','class'));
    }

    public function viewproj(Request $request,$id)
    {
        $form = project_doc::find($id);
        $class = 1;
        $formtype = $form->type;
        $proj_num = $form->proj_num;
        $editorContent = $form->detail;
        $projName = $form->title;
        $projNo = $form->proj_code;
        return view('/forms/'.$formtype, compact( 'proj_num','projName','class', 'projNo','editorContent'));
    }

    public function viewmou(Request $request,$id) 
    {
        $form = mou_doc::find($id);
        
        $class = 1;
        $formtype = $form->type;
        $editorContent = $form->detail;

        $subject = $form->title;
        $party1 = $form->party1;
        $location = $form->place;
        $mou_num = $form->mou_num;
        $parties = json_decode($form->parties, true);
        // dd($parties);
        return view('/forms/'.$formtype, compact( 'mou_num','parties', 'location', 'subject', 'party1','class','editorContent'));
    }
}
