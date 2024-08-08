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
use App\Models\costs_doc;
use App\Models\department;
use App\Models\jd_doc;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

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
        // หน้า wi form
        // $currentYear = now()->year;
        // $len = gendoc::where('type', 'wiForm')->whereYear('created_at', $currentYear)->count() + 1;
        $len = gendoc::withTrashed()->where('type', 'wiForm')->count() + 1;
        $class = 0;
        return view('/forms/wiForm', compact('class','len'));
    }

    public function checkForm()
    {
        // หน้า checklist form
        // $currentYear = now()->year;
        // $len = gendoc::where('type', 'LIKE' , 'checkForm%')->whereYear('created_at', $currentYear)->count()+1;
        $len = gendoc::withTrashed()->where('type', 'LIKE' , 'checkForm%')->count()+1;
        $class = 0;
        return view('/forms/checkForm', compact('class','len'));
    }

    public function costForm()
    {
        $len = gendoc::withTrashed()->where('type', 'LIKE' , 'costForm%')->count()+1;
        $class = 0;
        return view('/forms/costForm', compact('class','len'));
    }

    public function courseForm()
    {
        // หน้า course form
        // $currentYear = now()->year;
        // $len = gendoc::where('type', 'LIKE' , 'courseForm%')->whereYear('created_at', $currentYear)->count()+1;
        $len = gendoc::withTrashed()->where('type', 'LIKE' , 'courseForm%')->count()+1;
        $class = 0;
        return view('/forms/courseForm', compact('class','len'));
    }

    public function mediaForm()
    {
        // หน้า media form
        // $currentYear = now()->year;
        // $len = gendoc::where('type', 'LIKE' , 'mediaForm%')->whereYear('created_at', $currentYear)->count()+1;
        $len = gendoc::withTrashed()->where('type', 'LIKE' , 'mediaForm%')->count()+1;
        $class = 0;
        return view('/forms/mediaForm', compact('class','len'));
    }

    public function jdForm()
    {
        // หน้า jd form
        $currentYear = now()->year;
        $len = jd_doc::withTrashed()->whereYear('created_at', $currentYear)->count()+1;
        $class = 0;
        return view('/forms/jdForm', compact('class', 'len'));
    }
    public function sopForm()
    {
        // หน้า sop form
        $currentYear = now()->year;
        $len = gendoc::withTrashed()->where('type', 'sopForm')->whereYear('created_at', $currentYear)->count()+1;
        $class = 0;
        return view('/forms/sopForm', compact('class', 'len'));
    }
    public function policyForm()
    {
        // หน้า policy form
        $currentYear = now()->year;
        $len = gendoc::withTrashed()->where('type', 'policyForm')->whereYear('created_at', $currentYear)->count()+1;
        $class = 0;
        return view('/forms/policyForm', compact('class', 'len'));
    }
    public function annoForm()
    {
        // หน้า ประกาศ form
        $currentYear = now()->year;
        $len = announce_doc::withTrashed()->whereYear('created_at', $currentYear)->count()+1;
        $class = 0;
        return view('/forms/annoForm', compact('class', 'len'));
    }
    public function projForm()
    {
        // หน้า โครงการ form
        $currentYear = now()->year;
        $len = project_doc::withTrashed()->whereYear('created_at', $currentYear)->count()+1;
        $class = 0;
        return view('/forms/projForm', compact('class', 'len'));
    }
    public function mouForm()
    {
        // หน้า mou form
        $currentYear = now()->year;
        $len = mou_doc::withTrashed()->whereYear('created_at', $currentYear)->count()+1;
        $class = 0;
        return view('/forms/mouForm', compact('class', 'len'));
    }
    public function preview(Request $request)
    {
        // preview เอกสารแต่ละประเภท
        if ($request->input('submit') === "preview") {
            $request->validate([
                'myInput'=>'required'
            ]);
            $formtype = $request->input('formtype');
            $class = 1;
            $editorContent = $request->input('myInput');
            if ($request->input('iframeElement')) {
                $editorContent = $editorContent.$request->input('iframeElement');
            }
            $parties = [];

            if ($formtype === "projForm") {
                $book_num = $request->book_num;
                $proj_subm = $request->proj_subm ?? '       ';
                $proj_ins = $request->proj_ins ?? '       ';
                $proj_app = $request->proj_app ?? '       ';
                $projName = $request->input('projName');
                $projNo = $request->input('projNo');
                return view('/forms/'.$formtype, compact('proj_app','proj_ins','proj_subm' ,'book_num','projName','class', 'projNo','editorContent'));
            }
            elseif ($formtype === "mouForm") {
                $subject = $request->input('subject');
                $party1 = $request->input('party1');
                $location = $request->input('location');
                $book_num = $request->book_num;
                if ($request->input('party2')) {
                    $parties[] = $request->input('party2');
                };
                if ($request->input('party3')){
                    $parties[] = $request->input('party3');
                };
                if ($request->input('party4')){
                    $parties[] = $request->input('party4');
                };
                if ($request->input('party5')){
                    $parties[] = $request->input('party5');
                };
                $allSigns = [];  // Initialize an array to hold all sign arrays
                if ($request->signCount) {
                    for ($i = 1; $i <= $request->signCount; $i++) {
                        $sign = [
                            'signName' => $request->input("signname{$i}"),  // Access input values using input() method
                            'signPos' => $request->input("signpos{$i}")
                        ];
                        $allSigns[] = $sign;  // Add the current sign array to the collection
                    }
                };
                return view('/forms/'.$formtype, compact('allSigns' ,'book_num','parties', 'location', 'subject', 'party1','class','editorContent'));


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
        // บันทึกเอกสารแต่ละประเภทไปยัง Database
        $formtype = $request->input('formtype');
        if ($formtype === "projForm") {
            $data = [
                'proj_subm' => $request->proj_subm ?? '',
                'proj_ins' => $request->proj_ins ?? '',
                'proj_app' => $request->proj_app ?? '',
            ];
            $project_doc = new project_doc;
            $project_doc->book_num = $request->book_num;
            $project_doc->proj_code = $request->projNo;
            $project_doc->submit_by = $request->user()->id;
            $project_doc->type = $request->formtype;
            $project_doc->title = $request->projName;
            $project_doc->detail = $request->editorContent;
            $project_doc->sign = json_encode($data);
            $project_doc->dpm = (department::find($request->user()->dpm))->prefix;
            $project_doc->created_date = date('Y-m-d');
            $project_doc->stat = 'ยังไม่ได้ตรวจสอบ';
            $project_doc->save();
            Alert::toast('Your Form as been Saved!','success');

        }
        elseif ($formtype === "mouForm"){
            $mou_doc = new mou_doc;
            $mou_doc->book_num = $request->book_num;
            $mou_doc->submit_by = $request->user()->id;
            $mou_doc->type = $request->formtype;
            $mou_doc->title = $request->subject;
            $mou_doc->party1 = $request->party1;
            $mou_doc->parties = $request->parties ?? '';
            // $mou_doc->parties = json_decode($request->input('parties'), true);
            $mou_doc->place = $request->location;
            $mou_doc->detail = $request->editorContent;
            $mou_doc->sign = $request->allSigns;
            $mou_doc->dpm = (department::find($request->user()->dpm))->prefix;
            $mou_doc->created_date = date('Y-m-d');
            $mou_doc->stat = 'ยังไม่ได้ตรวจสอบ';
            $mou_doc->save();
            Alert::toast('Your Form as been Saved!','success');

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
            $announce_doc->dpm = (department::find($request->user()->dpm))->prefix;
            $announce_doc->sign_name = $request->signName;
            $announce_doc->sign_position = $request->signPosition;
            $announce_doc->stat = 'ยังไม่ได้ตรวจสอบ';
            $announce_doc->save();
            Alert::toast('Your Form as been Saved!','success');
        }
        else{
            if ($formtype === "costForm") {
                $gendoc = new costs_doc;
            } elseif ($formtype === "jdForm") {
                $gendoc = new jd_doc;
            } else {
                $gendoc = new gendoc;
            }
            $gendoc->book_num = $request->bookNo;
            $gendoc->submit_by = $request->user()->id;
            $gendoc->created_date = date('Y-m-d');
            $gendoc->type = $request->formtype. ($request->subtype? ".".$request->subtype : '');
            $gendoc->title = $request->subject;
            $gendoc->bcreater = $request->creater;
            $gendoc->binspector = $request->inspector;
            $gendoc->bapprover = $request->approver;
            $gendoc->detail = $request->editorContent;
            $gendoc->dpm = (department::find($request->user()->dpm))->prefix;
            $gendoc->stat = 'ยังไม่ได้ตรวจสอบ';
            $gendoc->save();
            Alert::toast('Your Form as been Saved!','success');
        }
    }

    // Function for edit form
    public function editFormwi(Request $request,$id){
        // แก้ไข wi form
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/wiForm', compact('form'));
    }

    // Function for download form
    public function downloadFormwi(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = gendoc::find($did);
        // dd($form);
        if ($form) {
            $formtype = $form->type;
            $class = 1;
            $editorContent = $form->detail;
            $bookNo = $form->book_num;
            $subject = $form->title;
            $creater = $form->bcreater;
            $inspector = $form->binspector;
            $approver = $form->bapprover;
            $submitb = $form->submit_by;
        }
        return view('/forms/export/wiForm', compact('submitb','form', 'dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));

    }

    // Function for edit form
    public function editFormmedia(Request $request,$id){
        // แก้ไข wi form
        $form = gendoc::find($id);
        return view('/editForms/mediaForm', compact('form'));
    }

    // Function for download form
    public function downloadFormmedia(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = gendoc::find($did);
        // dd($form);
        if ($form) {
            $formtype = $form->type;
            $class = 1;
            $editorContent = $form->detail;
            $bookNo = $form->book_num;
            $subject = $form->title;
            $creater = $form->bcreater;
            $inspector = $form->binspector;
            $approver = $form->bapprover;
            $submitb = $form->submit_by;
        }
        return view('/forms/export/mediaForm', compact('submitb','form', 'dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));

    }

    // Function for edit form
    public function editFormcourse(Request $request,$id){
        // แก้ไข wi form
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/courseForm', compact('form'));
    }

    // Function for download form
    public function downloadFormcourse(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = gendoc::find($did);
        // dd($form);
        if ($form) {
            $formtype = $form->type;
            $class = 1;
            $editorContent = $form->detail;
            $bookNo = $form->book_num;
            $subject = $form->title;
            $creater = $form->bcreater;
            $inspector = $form->binspector;
            $approver = $form->bapprover;
            $submitb = $form->submit_by;
        }
        return view('/forms/export/courseForm', compact('submitb', 'form', 'dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));

    }

    // Function for edit form
    public function editFormcheck(Request $request,$id){
        // แก้ไข wi form
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/checkForm', compact('form'));
    }

    // Function for download form
    public function downloadFormcheck(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = gendoc::find($did);
        // dd($form);
        if ($form) {
            $formtype = $form->type;
            $class = 1;
            $editorContent = $form->detail;
            $bookNo = $form->book_num;
            $subject = $form->title;
            $creater = $form->bcreater;
            $inspector = $form->binspector;
            $approver = $form->bapprover;
            $submitb = $form->submit_by;
        }
        return view('/forms/export/checkForm', compact('submitb', 'form', 'dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));

    }

    public function editFormcost(Request $request,$id){
        // แก้ไข wi form
        $form = costs_doc::find($id);
        // dd($form->title);
        return view('/editForms/costForm', compact('form'));
    }

    // Function for download form
    public function downloadFormcost(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = costs_doc::find($did);
        // dd($form);
        if ($form) {
            $formtype = $form->type;
            $class = 1;
            $editorContent = $form->detail;
            $bookNo = $form->book_num;
            $subject = $form->title;
            $creater = $form->bcreater;
            $inspector = $form->binspector;
            $approver = $form->bapprover;
            $submitb = $form->submit_by;

            $app = json_decode($form->app);
            $ins = json_decode($form->ins);
            $appName = User::find($app->appId ?? '');
            $insName = User::find($ins->appId ?? '');
            $submit_id = json_decode($form->submit_by ?? '');

            // check type of submit_id
            if (is_array($submit_id)) {
                $owner = User::find($submit_id[0]);
            } else {
                $owner = User::find($submit_id);
            }

            $cPath = public_path('files/signs/' . ($owner->image ?? ''));
            $csign = File::exists($cPath);

            $iPath = public_path('files/signs/' . ($insName->image ?? ''));
            $isign = File::exists($iPath);

            $aPath = public_path('files/signs/' . ($appName->image ?? ''));
            $asign = File::exists($aPath);
        }
        return view('/forms/export/costForm',
            compact('submitb', 'form', 'dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class', 'csign', 'appName', 'insName', 'owner', 'isign', 'asign'));

    }

    // Function for edit form
    public function editFormsop(Request $request,$id){
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/sopForm', compact('form'));
    }

    // Function for download form
    public function downloadFormsop(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = gendoc::find($did);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        $submitb = $form->submit_by;
        return view('/forms/export/sopForm', compact('submitb', 'form','dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    public function editFormjd(Request $request,$id){
        $form = jd_doc::find($id);
        // dd($form->title);
        return view('/editForms/jdForm', compact('form'));
    }

    // Function for download form
    public function downloadFormjd(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = jd_doc::find($did);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        $submitb = $form->submit_by;
        return view('/forms/export/jdForm', compact('submitb', 'form','dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    // Function for edit form
    public function editFormproj(Request $request,$id){
        $form = project_doc::find($id);
        return view('/editForms/projForm', compact('form'));
    }

    // Function for download form
    public function downloadFormproj(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = project_doc::find($did);
        $data = [
            'proj_subm' => '',
            'proj_ins' => '',
            'proj_app' => '',
        ];
        $class = 1;
        $formtype = $form->type;
        $book_num = $form->book_num;
        $editorContent = $form->detail;
        $projName = $form->title;
        $projNo = $form->proj_code;
        $sign = json_decode($form->sign ?? json_encode($data));
        $submitb = $form->submit_by;
        return view('/forms/export/projForm', compact('submitb', 'sign' ,'dorv' ,'book_num','projName','class', 'projNo','editorContent'));
    }

    // Function for edit form
    public function editFormpol(Request $request,$id){
        $form = gendoc::find($id);
        // dd($form->title);
        return view('/editForms/policyForm', compact('form'));
    }

    // Function for download form
    public function downloadFormpol(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = gendoc::find($did);
        // dd($form);
        $formtype = $form->type;
        $class = 1;
        $editorContent = $form->detail;
        $bookNo = $form->book_num;
        $subject = $form->title;
        $creater = $form->bcreater;
        $inspector = $form->binspector;
        $approver = $form->bapprover;
        $submitb = $form->submit_by;
        return view('/forms/export/policyForm', compact('submitb', 'form','dorv' ,'bookNo','editorContent', 'approver', 'inspector', 'creater','subject','class'));
    }

    // Function for edit form
    public function editFormmou(Request $request,$id){
        $form = mou_doc::find($id);
        return view('/editForms/mouForm', compact('form'));
    }

    // Function for download form
    public function downloadFormmou(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = mou_doc::find($did);

        $class = 1;
        $formtype = $form->type;
        $editorContent = $form->detail;
        $allSigns = json_decode($form->sign);
        $subject = $form->title;
        $party1 = $form->party1;
        $location = $form->place;
        $book_num = $form->book_num;
        $parties = json_decode($form->parties, true);
        $submitb = $form->submit_by;
        return view('/forms/export/mouForm', compact('submitb', 'allSigns' ,'dorv' ,'book_num','parties', 'location', 'subject', 'party1','class','editorContent'));
    }

    // Function for edit form
    public function editFormanno(Request $request,$id){
        $form = announce_doc::find($id);
        return view('/editForms/annoForm', compact('form'));
    }

    // Function for download form
    public function downloadFormanno(Request $request,$dorv,$id){
        $did = Crypt::decrypt($id);
        $form = announce_doc::find($did);
        $class = 1;
        $formtype = $form->type;
        $editorContent = $form->detail;
        $annNo = $form->book_num;
        $subject = $form->title;
        $annoDate = $form->anno_date;
        $useDate = $form->use_date;
        $signName = $form->sign_name;
        $signPosition = $form->sign_position;
        $submitb = $form->submit_by;
        return view('/forms/export/annoForm', compact('submitb', 'dorv' ,'annNo','signName', 'signPosition','annoDate', 'useDate', 'editorContent','subject','class'));
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
            $allSigns = [];
            if ($request->signCount) {
                for ($i = 1; $i <= $request->signCount; $i++) {
                    if ($request->input("signname{$i}") && $request->input("signpos{$i}")) {
                        $sign = [
                            'signName' => $request->input("signname{$i}"),  // Access input values using input() method
                            'signPos' => $request->input("signpos{$i}")
                        ];
                        $allSigns[] = $sign;
                    }
                }
            };
            if ($form) {
                $form->title = $request->subject;
                $form->party1 = $request->party1;
                $form->parties = $parties;
                $form->place = $request->location;
                $form->detail = $request->myInput;
                $form->sign = json_encode($allSigns);
                $form->save();
            }
            Alert::toast('Your Form as been Updated!','success');
            return redirect('/tables/mouTable');
        }
        elseif ($request->formtype === "projForm") {
            $form = project_doc::find($request->formid);
            if ($form) {
                // Row with id found, update data
                $data = [
                    'proj_subm' => $request->proj_subm ?? '',
                    'proj_ins' => $request->proj_ins ?? '',
                    'proj_app' => $request->proj_app ?? '',
                ];
                $form->title = $request->projName;
                $form->detail = $request->myInput;
                $form->proj_code = $request->projNo;
                $form->created_date = date('Y-m-d');
                $form->sign = json_encode($data);
                $form->save();
            }
            Alert::toast('Your Form as been Updated!','success');
            return redirect('/tables/projTable');
        }
        else {
            if ($request->formtype === "costForm") {
                $form = costs_doc::find($request->formid);
            } elseif ($request->formtype === "jdForm") {
                $form = jd_doc::find($request->formid);
            } else {
                $form = gendoc::find($request->formid);
            }
            if ($form) {
                $editorContent = $request->myInput;
                if ($request->input('iframeElement')) {
                    $editorContent = $editorContent.$request->input('iframeElement');
                }
                // Row with id found, update data
                $form->title = $request->subject;
                $form->bcreater = $request->creater;
                $form->binspector = $request->inspector;
                $form->bapprover = $request->approver;
                $form->detail = $editorContent;
                $form->type = $request->formtype. ($request->subtype? ".".$request->subtype : '');
                $form->save();
            }
            Alert::toast('Your Form as been Updated!','success');
            if ($request->formtype === "wiForm") {
                return redirect('/tables/wiTable');
            } elseif ($request->formtype === "sopForm") {
                return redirect('/tables/sopTable');
            } elseif ($request->formtype === "policyForm") {
                return redirect('/tables/policyTable');
            } elseif ($request->formtype === "costForm") {
                return redirect('/tables/costTable');
            } elseif ($request->formtype === "jdForm") {
                return redirect('/tables/jdTable');
            } else {
                return redirect('home');
            };
        }
    }

}
