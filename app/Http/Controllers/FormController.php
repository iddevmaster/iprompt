<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gendoc;
use App\Models\project_doc;
use App\Models\announce_doc;
use App\Models\mou_doc;

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
        $class = 0;
        return view('/forms/projForm', compact('class'));
    }
    public function mouForm()
    {
        $class = 0;
        return view('/forms/mouForm', compact('class'));
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
                $projName = $request->input('projName');
                $projNo = $request->input('projNo');
                return view('/forms/'.$formtype, compact('projName','class', 'projNo','editorContent'));
            }
            elseif ($formtype === "mouForm") {
                $subject = $request->input('subject');
                $party1 = $request->input('party1');
                $location = $request->input('location');

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
                return view('/forms/'.$formtype, compact('parties', 'location', 'subject', 'party1','class','editorContent'));
                
                
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
            return redirect('/home');
        }
    }

    public function store(Request $request)
    {
        $formtype = $request->input('formtype');
        if ($formtype === "projForm") {
            $project_doc = new project_doc;

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
}
