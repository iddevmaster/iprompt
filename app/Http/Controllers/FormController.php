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
use App\Models\DarDocument;
use App\Models\department;
use App\Models\DocActionReq;
use App\Models\jd_doc;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
        $len = costs_doc::withTrashed()->count() + 1;
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

    public function darForm()
    {
        // หน้า document action request form
        $lastDar = DocActionReq::latest('created_at')->first();
        $len = $lastDar ? $lastDar->id+1 : 1;
        return view('/forms/darForm', compact('len'));
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

    public function duplicateForm(Request $request, $formtype, $id, $darid)
    {
        $return_type = '-';
        // duplicate form
        if ($formtype === 'annoForm') {
            $form = announce_doc::find($id);
            $return_type = 'editanno';
        }
        elseif ($formtype === 'mouForm') {
            $form = mou_doc::find($id);
            $return_type = 'editmou';
        }
        elseif ($formtype === 'projForm') {
            $form = project_doc::find($id);
            $return_type = 'editproj';
        }
        elseif ($formtype === 'costForm') {
            $form = costs_doc::find($id);
            $return_type = 'editcost';
        }
        elseif ($formtype === 'jdForm') {
            $form = jd_doc::find($id);
            $return_type = 'editjd';
        }
        else {
            $form = gendoc::find($id);
            switch ($formtype) {
                case 'wiForm':
                    $return_type = 'editwi';
                    break;
                case 'mediaForm':
                    $return_type = 'editmedia';
                    break;
                case 'courseForm':
                    $return_type = 'editcourse';
                    break;
                case 'checkForm':
                    $return_type = 'editcheck';
                    break;
                case 'sopForm':
                    $return_type = 'editsop';
                    break;
                case 'policyForm':
                    $return_type = 'editpol';
                    break;
                default:
                    // Handle unknown form type if necessary
                    break;
            }
        }

        $copy = $form->replicate();
        $copy->stat = 'ยังไม่ได้ตรวจสอบ';
        $copy->app = null;
        $copy->ins = null;
        $copy->created_date = date('Y-m-d');
        $editCount = $form->edit_count + 1;
        $copy->edit_count = $editCount;
        $parts = explode('-', $form->book_num);
        $parts[3] = str_pad($editCount, 2, '0', STR_PAD_LEFT);
        $newBookNum = implode('-', $parts);
        $copy->book_num = $newBookNum;
        $copy->save();
        DarDocument::where('id', $darid)->update(['status' => 2]); // 2 = completed
        return redirect('/form/'.$return_type.'/'.$copy->id);
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

    public function storeDarForm(Request $request) {
        $request->validate([
            'bnum' => 'required|string|max:255',
            'req_for' => 'required|string|max:255',
            'doc_owner' => 'required|string|max:255',
            'req_by' => 'required|string|max:255',
            'req_date' => 'required|date',
            'doc_types' => 'required|array|min:1',
            'doc_types.*' => 'string',
            'doc_target' => 'required|array|min:1',
            'doc_target.*' => 'string',
        ], [
            'bnum.required' => 'กรุณากรอกเลขที่หนังสือ',
            'bnum.string' => 'เลขที่หนังสือต้องเป็นข้อความ',
            'bnum.max' => 'เลขที่หนังสือต้องไม่เกิน :max ตัวอักษร',

            'req_for.required' => 'กรุณาระบุเหตุผลการขอ',
            'req_for.string' => 'ขอเพื่อ ต้องเป็นข้อความ',
            'req_for.max' => 'ขอเพื่อ ต้องไม่เกิน :max ตัวอักษร',

            'doc_owner.required' => 'กรุณาระบุผู้ถือครอง',
            'doc_owner.string' => 'ผู้ถือครองต้องเป็นข้อความ',
            'doc_owner.max' => 'ผู้ถือครองต้องไม่เกิน :max ตัวอักษร',

            'req_by.required' => 'กรุณาระบุผู้ขอ',
            'req_by.string' => 'ผู้ขอต้องเป็นข้อความ',
            'req_by.max' => 'ผู้ขอต้องไม่เกิน :max ตัวอักษร',

            'req_date.required' => 'กรุณาระบุวันที่ขอ',
            'req_date.date' => 'รูปแบบวันที่ไม่ถูกต้อง',

            'doc_types.required' => 'กรุณาเลือกประเภทเอกสาร',
            'doc_types.array' => 'ค่าประเภทเอกสารไม่ถูกต้อง',
            'doc_types.min' => 'กรุณาเลือกประเภทเอกสารอย่างน้อย :min รายการ',
            'doc_types.*.string' => 'ประเภทเอกสารต้องเป็นข้อความ',

            'doc_target.required' => 'กรุณาเลือกเอกสารที่ดำเนินการ',
            'doc_target.array' => 'ค่าของเอกสารที่ดำเนินการไม่ถูกต้อง',
            'doc_target.min' => 'กรุณาเลือกเอกสารที่ดำเนินการอย่างน้อย :min รายการ',
            'doc_target.*.string' => 'ค่าที่เลือกของเอกสารต้องเป็นข้อความ',
        ]);

        $new_dar = DocActionReq::create([
            'dar_id' => Str::uuid()->toString(),
            'doc_type'  => json_encode($request->doc_types),
            'book_num'  => $request->bnum,
            'action_type'  => $request->req_for,
            'created_by'  => Auth::user()->id,
            'stat'  => 'ยังไม่ได้ตรวจสอบ',
            'dpm'  => (department::find($request->user()->dpm))->prefix,
            'request_by' => $request->req_by,
            'request_at' => $request->req_date,
            'doc_owner' => $request->doc_owner,
        ]);

        foreach ($request->doc_target ?? [] as $key => $doc) {
            $doc_data = explode('-', $doc);
            // dd($doc_data[0], $doc_data[1]);
            if (!DarDocument::where('dar_id', $new_dar->id)->where('doc_id', $doc_data[1])->exists()) {
                DarDocument::create([
                    'dar_id' => $new_dar->id,
                    'doc_id' => $doc_data[1],
                    'doc_type' => $doc_data[0],
                ]);
            }
        }

        Alert::toast('Your Form as been Saved!','success');
        return redirect('/home');
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

    public function downloadFormDar($darid) {
        $dar_data = DocActionReq::findOrFail($darid);
        $user = User::withTrashed()->get(['id', 'name', 'image']);
        $dar_doc_ids = DarDocument::where('dar_id', $darid)->get();

        $docs = collect();
        foreach ($dar_doc_ids as $key => $dar_doc) {
            if ($dar_doc->doc_type == 'PRO') {
                $docs = $docs->concat(
                    project_doc::where('id', $dar_doc->doc_id ?? '')->get(['id','proj_code','title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->proj_code, // แปลง key
                            'title'    => $item->title,
                            'type'     => 'PRO',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'ANNO') {
                $docs = $docs->concat(
                    announce_doc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'ANNO',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'MOU') {
                $docs = $docs->concat(
                    mou_doc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'MOU',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'COST') {
                $docs = $docs->concat(
                    costs_doc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'COST',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'JD') {
                $docs = $docs->concat(
                    jd_doc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'JD',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'WI') {
                $docs = $docs->concat(
                    gendoc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'WI',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'SOP') {
                $docs = $docs->concat(
                    gendoc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'SOP',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'POL') {
                $docs = $docs->concat(
                    gendoc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'POL',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'checklist') {
                $docs = $docs->concat(
                    gendoc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'checklist',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'course') {
                $docs = $docs->concat(
                    gendoc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'course',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }

            if ($dar_doc->doc_type == 'media') {
                $docs = $docs->concat(
                    gendoc::where('id', $dar_doc->doc_id ?? '')->get(['id','book_num', 'title', 'app', 'edit_count'])->map(function ($item) {
                        return [
                            'id'       => $item->id,
                            'book_num' => $item->book_num,
                            'title'    => $item->title,
                            'type'     => 'media',
                            'approve' => $item->app,
                            'edit_count' => $item->edit_count
                        ];
                    })
                );
            }
        }
        $docs_list = $docs->values();
        return view('/forms/export/darForm', compact('dar_data', 'user', 'docs_list'));
    }

}
