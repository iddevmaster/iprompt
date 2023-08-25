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
use App\Models\department;
use Illuminate\Support\Facades\Auth;


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
        if (Auth::user()->hasAnyRole('employee', 'leader_dpm')) {
            $gendoc = gendoc::where('type', 'wiForm')->where('dpm', (department::find((Auth::user())->dpm))->prefix)->orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->hasAnyRole('director', 'coo/cfo')) {
            $gendoc = gendoc::where('type', 'wiForm')->whereIn('dpm', json_decode((department::find((Auth::user())->dpm))->prefix))->orderBy('id', 'desc')->paginate(10);
        }
        else {
            $gendoc = gendoc::where('type', 'wiForm')->orderBy('id', 'desc')->paginate(10);
        };
        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $doc->dpm = (department::find((User::find($doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        return view('/tables/wiTable', compact('inspectors','approvers','gendoc', 'user'));
    }

    // query all sop form from database to sop table page
    public function sopTable() { 
        if (Auth::user()->hasAnyRole('employee', 'leader_dpm')) {
            $gendoc = gendoc::where('type', 'sopForm')->where('dpm', (department::find((Auth::user())->dpm))->prefix)->orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->hasAnyRole('director', 'coo/cfo')) {
            $gendoc = gendoc::where('type', 'sopForm')->whereIn('dpm', json_decode((department::find((Auth::user())->dpm))->prefix))->orderBy('id', 'desc')->paginate(10);
        }
        else {
            $gendoc = gendoc::where('type', 'sopForm')->orderBy('id', 'desc')->paginate(10);
        };
        $user = User::all();
        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $doc->dpm = (department::find((User::find($doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        return view('/tables/sopTable', compact('inspectors','approvers','gendoc', 'user'));
    }

    // query all policy form from database to policy table page
    public function policyTable() {
        if (Auth::user()->hasAnyRole('employee', 'leader_dpm')) {
            $gendoc = gendoc::where('type', 'policyForm')->where('dpm', (department::find((Auth::user())->dpm))->prefix)->orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->hasAnyRole('director', 'coo/cfo')) {
            $gendoc = gendoc::where('type', 'policyForm')->whereIn('dpm', json_decode((department::find((Auth::user())->dpm))->prefix))->orderBy('id', 'desc')->paginate(10);
        }
         else {
            $gendoc = gendoc::where('type', 'policyForm')->orderBy('id', 'desc')->paginate(10);
        };
        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $doc->dpm = (department::find((User::find($doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        return view('/tables/policyTable', compact('inspectors','approvers','gendoc', 'user'));
    }

    // query all mou form from database to mou table page
    public function mouTable() {
        if (Auth::user()->hasAnyRole('employee', 'leader_dpm')) {
            $gendoc = mou_doc::where('dpm', (department::find((Auth::user())->dpm))->prefix)->orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->hasAnyRole('director', 'coo/cfo')) {
            $gendoc = mou_doc::whereIn('dpm', json_decode((department::find((Auth::user())->dpm))->prefix))->orderBy('id', 'desc')->paginate(10);
        }
        else {
            $gendoc = mou_doc::orderBy('id', 'desc')->paginate(10);
        };

        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $doc->dpm = (department::find((User::find($doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        return view('/tables/mouTable', compact('inspectors','approvers','gendoc', 'user'));
    }

    // query all project form from database to project table page
    public function projTable() {
        if (Auth::user()->hasAnyRole('employee', 'leader_dpm')) {
            $gendoc = project_doc::where('dpm', (department::find((Auth::user())->dpm))->prefix)->orWhere('submit_by', 'LIKE', '%' . Auth::user()->id . '%')
                ->orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->hasAnyRole('director', 'coo/cfo')) {
            $gendoc = project_doc::whereIn('dpm', json_decode((department::find((Auth::user())->dpm))->prefix))->orderBy('id', 'desc')->paginate(10);
        }
        else {
            $gendoc = project_doc::orderBy('id', 'desc')->paginate(10);
        };
        
        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $doc->dpm = (department::find((User::find($doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        return view('/tables/projTable', compact('inspectors','approvers','gendoc', 'user'));
    }

    // query all anno form from database to anno table page
    public function annoTable() {
        if (Auth::user()->hasAnyRole('employee', 'leader_dpm')) {
            $gendoc = announce_doc::where('dpm', (department::find((Auth::user())->dpm))->prefix)->orderBy('id', 'desc')->paginate(10);
        } elseif (Auth::user()->hasAnyRole('director', 'coo/cfo')) {
            $gendoc = announce_doc::whereIn('dpm', json_decode((department::find((Auth::user())->dpm))->prefix))->orderBy('id', 'desc')->paginate(10);
        }
        else {
            $gendoc = announce_doc::orderBy('id', 'desc')->paginate(10);
        };

        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $doc->dpm = (department::find((User::find($doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        return view('/tables/annoTable', compact('inspectors','approvers','gendoc', 'user'));
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
        $book_num = $form->book_num;
        $editorContent = $form->detail;
        $projName = $form->title;
        $projNo = $form->proj_code;
        return view('/forms/'.$formtype, compact( 'book_num','projName','class', 'projNo','editorContent'));
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
        $book_num = $form->book_num;
        $parties = json_decode($form->parties, true);
        // dd($parties);
        return view('/forms/'.$formtype, compact( 'book_num','parties', 'location', 'subject', 'party1','class','editorContent'));
    }


    public function verifyDoc() {
        $gendocColumns = ['id', 'book_num', 'type', 'title', 'created_date', 'submit_by', 'stat', 'app', 'ins'];
        $mouDocColumns = ['id', 'book_num', 'type', 'title', 'created_date', 'submit_by', 'stat', 'app', 'ins'];
        $projectDocColumns = ['id', 'book_num', 'type', 'title', 'created_date', 'submit_by', 'stat', 'app', 'ins'];
        $announceDocColumns = ['id', 'book_num', 'type', 'title', 'created_date', 'submit_by', 'stat', 'app', 'ins'];
        
        $gendocQuery = gendoc::whereIn('stat', ['รอตรวจสอบ', 'รออนุมัติ'])->select($gendocColumns);
        $mouDocQuery = mou_doc::whereIn('stat', ['รอตรวจสอบ', 'รออนุมัติ'])->select($mouDocColumns);
        $projectDocQuery = project_doc::whereIn('stat', ['รอตรวจสอบ', 'รออนุมัติ'])->select($projectDocColumns);
        $announceDocQuery = announce_doc::whereIn('stat', ['รอตรวจสอบ', 'รออนุมัติ'])->select($announceDocColumns);
        
        $form = $gendocQuery
                    ->union($mouDocQuery)
                    ->union($projectDocQuery)
                    ->union($announceDocQuery)
                    ->get();
        $user = User::all();
        return view('/tables/verify', compact('form','user'));
    }

    public function setVerify(Request $request) {
        try {
            $id = $request->docId;
            if ($request->type === 'annoForm') { 
                $form = announce_doc::find($id);
            }
            elseif ($request->type === 'mouForm') { 
                $form = mou_doc::find($id);
            }
            elseif ($request->type === 'projForm') { 
                $form = project_doc::find($id);
            }
            else {
                $form = gendoc::find($id);
            }

            if ($request->status === 'ยังไม่ได้ตรวจสอบ' || $request->status === 'ไม่ผ่านการตรวจสอบ' || $request->status === 'ไม่ผ่านการอนุมัติ') {
                $app = [
                    'appId' => $request->app,
                    'note' => '-',
                    'date' => date('Y-m-d H:i:s'),
                ];
                $ins = [
                    'appId' => $request->ins,
                    'note' => '-',
                    'date' => date('Y-m-d H:i:s'),
                ];
                $form->app = $app;
                $form->ins = $ins;
                $form->stat = 'รอตรวจสอบ';
                $form->save();
            } elseif ($request->status === 'รอตรวจสอบ') {
                $ins = json_decode($form->ins);
                $ins->note = $request->note ?? '-';
                $ins->date = date('Y-m-d H:i:s');
                $form->ins = json_encode($ins);
                if ($request->res) {
                    $form->stat = 'รออนุมัติ';
                } else {
                    $form->stat = 'ไม่ผ่านการตรวจสอบ';
                }
                $form->save();
            } elseif ($request->status === 'รออนุมัติ') {
                $app = json_decode($form->app);
                $app->note = $request->note ?? '-';
                $app->date = date('Y-m-d H:i:s');
                $form->app = json_encode($app);
                if ($request->res) {
                    $form->stat = 'ผ่านการอนุมัติ';
                } else {
                    $form->stat = 'ไม่ผ่านการอนุมัติ';
                }
                $form->save();
            }
            Alert::toast('Form has been saved!','success');
            return response()->json($request);
        } catch (\Exception $e){
            return response()->json(['error' => $e]);
        }
        
    }

    public function exTable (Request $request, $type) {
        if ($type === 'wiTable') {
            $gendoc = gendoc::where('type', 'wiForm')->orderBy('id', 'desc')->get();
            $user = User::all();
            return view('/forms/export/'.$type, compact('gendoc', 'user'));
        } 
        elseif ($type === 'sopTable') {
            $gendoc = gendoc::where('type', 'sopForm')->orderBy('id', 'desc')->get();
            $user = User::all();
            return view('/forms/export/'.$type, compact('gendoc', 'user'));
        } 
        elseif ($type === 'policyTable') {
            $gendoc = gendoc::where('type', 'policyForm')->orderBy('id', 'desc')->get();
            $user = User::all();
            return view('/forms/export/'.$type, compact('gendoc', 'user'));
        } 
        elseif ($type === 'projTable') {
            $gendoc = project_doc::orderBy('id', 'desc')->get();
            $user = User::all();
            return view('/forms/export/'.$type, compact('gendoc', 'user'));
        } 
        elseif ($type === 'mouTable') {
            $gendoc = mou_doc::orderBy('id', 'desc')->get();
            $user = User::all();
            return view('/forms/export/'.$type, compact('gendoc', 'user'));
        } 
        elseif ($type === 'annoTable') {
            $gendoc = announce_doc::orderBy('id', 'desc')->get();
            $user = User::all();
            return view('/forms/export/'.$type, compact('gendoc', 'user'));
        } 
        elseif ($type === 'imported') {
            $gendoc = imported::orderBy('id', 'desc')->get();
            $user = User::all();
            $dpm = department::all();
            return view('/forms/export/'.$type, compact('gendoc', 'user', 'dpm'));
        };
    }

    public function addTeam(Request $request) {
        try {
            $data = [];
            $oldt = json_decode($request->oldT);
            if (is_array($oldt)) {
                $data = $oldt;
            } else {
                $data[] = $oldt;
            }
            
            $data[] = $request->memb;
            $gendoc = project_doc::find($request->bid);
            $gendoc->submit_by = $data;
            $gendoc->save();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
    

    public function clearTeam (Request $request) {
        try {
            $data = [];
            $oldt = json_decode($request->oldT);
            if (is_array($oldt)) {
                $data[] = $oldt[0];
            } else {
                $data[] = $oldt;
            }
            $gendoc = project_doc::find($request->bid);
            $gendoc->submit_by = $data;
            $gendoc->save();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
}
