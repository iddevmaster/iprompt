<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gendoc;
use App\Models\project_doc;
use App\Models\announce_doc;
use App\Models\mou_doc;
use Dompdf\Dompdf;
use PDF;
Use Alert;

class FormController extends Controller
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
    public function wiForm()
    {
        $len = gendoc::where('type', 'wiForm')->count()+1;
        $class = 0;
        return view('/forms/wiForm', compact('class','len'));
    }
    public function sopForm()
    {
        $len = gendoc::where('type', 'sopForm')->count()+1;
        $class = 0;
        return view('/forms/sopForm', compact('class', 'len'));
    }
    public function policyForm()
    {
        $len = gendoc::where('type', 'policyForm')->count()+1;
        $class = 0;
        return view('/forms/policyForm', compact('class', 'len'));
    }
    public function annoForm()
    {
        $len = announce_doc::all()->count()+1;
        $class = 0;
        return view('/forms/annoForm', compact('class', 'len'));
    }
    public function projForm()
    {
        $len = project_doc::all()->count()+1;
        $class = 0;
        return view('/forms/projForm', compact('class', 'len'));
    }
    public function mouForm()
    {
        $len = mou_doc::all()->count()+1;
        $class = 0;
        return view('/forms/mouForm', compact('class', 'len'));
    }
    public function preview(Request $request)
    {
        // dd($request);
        if ($request->input('submit') === "preview") {
            $request->validate([
                'myInput'=>'required'
            ]);
            $formtype = $request->input('formtype');
            $class = 1;
            $editorContent = $request->input('myInput');
            $parties = [];

            if ($formtype === "projForm") {
                $proj_num = $request->proj_num;
                $projName = $request->input('projName');
                $projNo = $request->input('projNo');
                return view('/forms/'.$formtype, compact( 'proj_num','projName','class', 'projNo','editorContent'));
            }
            elseif ($formtype === "mouForm") {
                $subject = $request->input('subject');
                $party1 = $request->input('party1');
                $location = $request->input('location');
                $mou_num = $request->mou_num;

                if ($request->input('party2')) {
                    $parties[] = $request->input('party2');
                }
                if ($request->input('party3')){
                    $parties[] = $request->input('party3');
                }
                if ($request->input('party4')){
                    $parties[] = $request->input('party4');
                }
                if ($request->input('party5')){
                    $parties[] = $request->input('party5');
                }
                return view('/forms/'.$formtype, compact( 'mou_num','parties', 'location', 'subject', 'party1','class','editorContent'));
                
                
            }
            elseif ($formtype === "annoForm") {
                $annNo = $request->input('annNo');
                $subject = $request->input('subject');
                $annoDate = $request->input('annoDate');
                $useDate = $request->input('useDate');
                $signName = $request->input('signName');
                $signPosition = $request->input('signPosition');
                return view('/forms/'.$formtype, compact( 'annNo','signName', 'signPosition','annoDate', 'useDate', 'editorContent','subject','class'));
            }
            else {
                $bookNo = $request->input('bookNo');
                $subject = $request->input('subject');
                $creater = $request->input('creater');
                $inspector = $request->input('inspector');
                $approver = $request->input('approver');
                return view('/forms/'.$formtype, compact( 'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
            }
        }
        else{
            $this->store($request);
            Alert::toast('Your Form as been Saved!','success');
            return redirect('/home');
        }
    }

    public function store(Request $request)
    {
        $formtype = $request->input('formtype');
        if ($formtype === "projForm") {
            $project_doc = new project_doc;
            $project_doc->proj_num = $request->proj_num;
            $project_doc->proj_code = $request->projNo;
            $project_doc->submit_by = $request->user()->id;
            $project_doc->type = $request->formtype;
            $project_doc->title = $request->projName;
            $project_doc->detail = $request->editorContent;
            $project_doc->sign = "";
            $project_doc->created_date = date('Y-m-d');
            $project_doc->save();
            
        }
        elseif ($formtype === "mouForm"){
            $mou_doc = new mou_doc;
            $mou_doc->mou_num = $request->mou_num;
            $mou_doc->submit_by = $request->user()->id;
            $mou_doc->type = $request->formtype;
            $mou_doc->title = $request->subject;
            $mou_doc->party1 = $request->party1;
            $mou_doc->parties = $request->parties;
            // $mou_doc->parties = json_decode($request->input('parties'), true);
            $mou_doc->place = $request->location;
            $mou_doc->detail = $request->editorContent;
            $mou_doc->sign = '';
            $mou_doc->created_date = date('Y-m-d');
            $mou_doc->save();

        }
        elseif ($formtype === "annoForm"){
            $announce_doc = new announce_doc;

            $announce_doc->book_num = $request->annNo;
            $announce_doc->submit_by = $request->user()->id;
            $announce_doc->created_date = date('Y-m-d');
            $announce_doc->type = $request->formtype;
            $announce_doc->title = $request->subject;
            $announce_doc->detail = $request->editorContent;
            $announce_doc->use_date = $request->useDate;
            $announce_doc->anno_date = $request->annoDate;
            $announce_doc->sign = '';
            $announce_doc->sign_name = $request->signName;
            $announce_doc->sign_position = $request->signPosition;
            $announce_doc->save();
        }   
        else{
            $gendoc = new gendoc;
            $gendoc->book_num = $request->bookNo;
            $gendoc->submit_by = $request->user()->id;
            $gendoc->created_date = date('Y-m-d');
            $gendoc->type = $request->formtype;
            $gendoc->title = $request->subject;
            $gendoc->bcreater = $request->creater;
            $gendoc->binspector = $request->inspector;
            $gendoc->bapprover = $request->approver;
            $gendoc->detail = $request->editorContent;
            $gendoc->save();
        }
    }

    // Function for edit form
    public function editFormwi(Request $request,$id){
        
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/wiForm', compact('form'));
    }

    // Function for download form
    public function downloadFormwi(Request $request,$id){
        $form = gendoc::find($id);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        return view('/forms/export/wiForm', compact( 'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
        
    }

    // Function for edit form
    public function editFormsop(Request $request,$id){
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/sopForm', compact('form'));
    }

    // Function for download form
    public function downloadFormsop(Request $request,$id){
        $form = gendoc::find($id);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        return view('/forms/export/sopForm', compact( 'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    // Function for edit form
    public function editFormproj(Request $request,$id){
        $form = project_doc::find($id);
        return view('/editForms/projForm', compact('form'));
    }

    // Function for download form
    public function downloadFormproj(Request $request,$id){
        $form = project_doc::find($id);
        $class = 1;
        $formtype = $form->type;
        $proj_num = $form->proj_num;
        $editorContent = $form->detail;
        $projName = $form->title;
        $projNo = $form->proj_code;
        return view('/forms/export/projForm', compact( 'proj_num','projName','class', 'projNo','editorContent'));
    }

    // Function for edit form
    public function editFormpol(Request $request,$id){
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/policyForm', compact('form'));
    }

    // Function for download form
    public function downloadFormpol(Request $request,$id){
        $form = gendoc::find($id);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        return view('/forms/export/policyForm', compact( 'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    // Function for edit form
    public function editFormmou(Request $request,$id){
        $form = mou_doc::find($id);
        return view('/editForms/mouForm', compact('form'));
    }

    // Function for download form
    public function downloadFormmou(Request $request,$id){
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
        return view('/forms/export/mouForm', compact( 'mou_num','parties', 'location', 'subject', 'party1','class','editorContent'));
    }

    // Function for edit form
    public function editFormanno(Request $request,$id){
        $form = announce_doc::find($id);
        return view('/editForms/annoForm', compact('form'));
    }

    // Function for download form
    public function downloadFormanno(Request $request,$id){
        
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
        return view('/forms/export/annoForm', compact( 'annNo','signName', 'signPosition','annoDate', 'useDate', 'editorContent','subject','class'));
    }

    public function update(Request $request) {
        if ($request->formtype === "annoForm") {
            $form = announce_doc::find($request->formid);
            if ($form) {
                // Row with id found, update data
                $form->title = $request->subject;
                $form->detail = $request->myInput;
                $form->use_date = $request->useDate;
                $form->anno_date = $request->annoDate;
                $form->sign_name = $request->signName;
                $form->sign_position = $request->signPosition;
                $form->save();
            }
            Alert::toast('Your Form as been Updated!','success');
            return redirect('/tables/annoTable');
        }
        elseif ($request->formtype === "mouForm") {
            $form = mou_doc::find($request->formid);
            $parties = [];
            if ($request->input('aparty1')) {
                $parties[] = $request->input('aparty1');
            }
            if ($request->input('aparty2')) {
                $parties[] = $request->input('aparty2');
            }
            if ($request->input('party2')) {
                $parties[] = $request->input('party2');
            }
            if ($request->input('party3')) {
                $parties[] = $request->input('party3');
            }
            if ($form) {
                $form->title = $request->subject;
                $form->party1 = $request->party1;
                $form->parties = $parties;
                $form->place = $request->location;
                $form->detail = $request->myInput;
                $form->save();
            }
            Alert::toast('Your Form as been Updated!','success');
            return redirect('/tables/mouTable');
        }
        elseif ($request->formtype === "projForm") {
            $form = project_doc::find($request->formid);
            if ($form) {
                // Row with id found, update data
                $form->title = $request->projName;
                $form->detail = $request->myInput;
                $form->proj_code = $request->projNo;
                $form->save();
            }
            Alert::toast('Your Form as been Updated!','success');
            return redirect('/tables/projTable');
        }
        else {
            $form = gendoc::find($request->formid);
            if ($form) {
                // Row with id found, update data
                $form->title = $request->subject;
                $form->bcreater = $request->creater;
                $form->binspector = $request->inspector;
                $form->bapprover = $request->approver;
                $form->detail = $request->myInput;
                $form->save();
            }
            Alert::toast('Your Form as been Updated!','success');
            if ($request->formtype === "wiForm") {
                return redirect('/tables/wiTable');
            } elseif ($request->formtype === "sopForm") {
                return redirect('/tables/sopTable');
            } else {
                return redirect('/tables/policyTable');
            }
            
        }
        
        
    }
    
}
