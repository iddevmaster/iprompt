<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gendoc;
use App\Models\User;
use App\Models\project_doc;
use App\Models\announce_doc;
use App\Models\mou_doc;
use App\Models\imported;
use App\Models\type;
use PDF;
Use Alert;
use App\Models\Contract;
use App\Models\department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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

    public function contTable () {
        $contracts = Contract::orderBy('id', 'desc')->get();
        $user = User::all();
        $dpms = department::all();
        return view('/tables/contTable', compact('contracts', 'user', 'dpms'));
    }

    // query all wi form from database to wi table page
    public function wiTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = gendoc::where('type', 'wiForm')
                ->where(function ($query) {
                    $query->where('dpm', (department::find((Auth::user())->dpm))->prefix)
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif ((Auth::user()->hasRole('employee'))) {
            $gendoc = gendoc::where('type', 'wiForm')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = gendoc::where('type', 'wiForm')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        else {
            $gendoc = gendoc::where('type', 'wiForm')
                ->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        };
        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        $dpms = department::all();
        return view('/tables/wiTable', compact('inspectors','approvers','gendoc', 'user', 'dpms'));
    }

    public function checkTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = gendoc::where('type', 'LIKE', 'checkForm%')
                ->where(function ($query) {
                    $query->where('dpm', (department::find((Auth::user())->dpm))->prefix)
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif ((Auth::user()->hasRole('employee'))) {
            $gendoc = gendoc::where('type', 'LIKE', 'checkForm%')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = gendoc::where('type', 'LIKE', 'checkForm%')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                    ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        else {
            $gendoc = gendoc::where('type', 'LIKE', 'checkForm%')->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        };
        foreach($gendoc as $doc) {
            if ($doc->dpm == '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };

        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        $type = type::where('type', 'check')->get();
        $dpms = department::all();
        return view('/tables/checkTable', compact('inspectors','approvers','gendoc', 'user', 'type', 'dpms'));
    }

    public function courseTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = gendoc::where('type', 'LIKE', 'courseForm%')
                ->where(function ($query) {
                    $query->where('dpm', (department::find((Auth::user())->dpm))->prefix)
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif ((Auth::user()->hasRole('employee'))) {
            $gendoc = gendoc::where('type', 'LIKE', 'courseForm%')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = gendoc::where('type', 'LIKE', 'courseForm%')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        else {
            $gendoc = gendoc::where('type', 'LIKE', 'courseForm%')->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        };
        foreach($gendoc as $doc) {
            if ($doc->dpm == '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        $type = type::where('type', 'course')->get();
        $dpms = department::all();
        return view('/tables/courseTable', compact('inspectors','approvers','gendoc', 'user', 'type', 'dpms'));
    }

    public function mediaTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = gendoc::where('type', 'LIKE', 'mediaForm%')
                ->where(function ($query) {
                    $query->where('dpm', (department::find((Auth::user())->dpm))->prefix)
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif ((Auth::user()->hasRole('employee'))) {
            $gendoc = gendoc::where('type', 'LIKE', 'mediaForm%')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')
                        ->orWhere('stat', 'ผ่านการอนุมัติ');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = gendoc::where('type', 'LIKE', 'mediaForm%')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('stat', 'ผ่านการอนุมัติ');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        else {
            $gendoc = gendoc::where('type', 'LIKE', 'mediaForm%')->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        };
        foreach($gendoc as $doc) {
            if ($doc->dpm == '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        $type = type::where('type', 'media')->get();
        $dpms = department::all();
        return view('/tables/mediaTable', compact('inspectors','approvers','gendoc', 'user', 'type', 'dpms'));
    }

    // query all sop form from database to sop table page
    public function sopTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = gendoc::where('type', 'sopForm')
                ->where(function ($query) {
                    $query->where('dpm', (department::find((Auth::user())->dpm))->prefix)
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif ((Auth::user()->hasRole('employee'))) {
            $gendoc = gendoc::where('type', 'sopForm')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = gendoc::where('type', 'sopForm')
                ->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        else {
            $gendoc = gendoc::where('type', 'sopForm')->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        };
        $user = User::all();
        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        $dpms = department::all();
        return view('/tables/sopTable', compact('inspectors','approvers','gendoc', 'user', 'dpms'));
    }

    // query all policy form from database to policy table page
    public function policyTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = gendoc::where('type', 'policyForm')
                ->where(function ($query) {
                    $query->where('dpm', (department::find((Auth::user())->dpm))->prefix)
                        ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif ((Auth::user()->hasRole('employee'))) {
            $gendoc = gendoc::where('type', 'policyForm')->where(function ($query) {
                    $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                        ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = gendoc::where('type', 'policyForm')->where(function ($query) {
                $query->where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')
                    ->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')
                    ->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%');
                })->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        }
         else {
            $gendoc = gendoc::where('type', 'policyForm')->orderBy('id', 'desc')
                ->select([
                    'id',
                    'book_num',
                    'submit_by',
                    'created_date',
                    'type',
                    'title',
                    'bcreater',
                    'binspector',
                    'bapprover',
                    'shares',
                    'files',
                    'edit_count',
                    'stat',
                    'app',
                    'ins',
                    'dpm',
                ])
                ->get();
        };
        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        $dpms = department::all();
        return view('/tables/policyTable', compact('inspectors','approvers','gendoc', 'user', 'dpms'));
    }

    // query all mou form from database to mou table page
    public function mouTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = mou_doc::where('dpm', (department::find((Auth::user())->dpm))->prefix)->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orderBy('id', 'desc')->get();
        }
        elseif (Auth::user()->hasRole('employee')) {
            $gendoc = mou_doc::where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orderBy('id', 'desc')->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = mou_doc::where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')->orderBy('id', 'desc')->get();
        }
        else {
            $gendoc = mou_doc::orderBy('id', 'desc')->get();
        };

        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        $dpms = department::all();
        return view('/tables/mouTable', compact('inspectors','approvers','gendoc', 'user', 'dpms'));
    }

    // query all project form from database to project table page
    public function projTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = project_doc::where('dpm', (department::find((Auth::user())->dpm))->prefix)->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orderBy('id', 'desc')->get();
        }
        elseif (Auth::user()->hasRole('employee')) {
            $gendoc = project_doc::where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orderBy('id', 'desc')->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = project_doc::where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')->orderBy('id', 'desc')->get();
        }
        else {
            $gendoc = project_doc::orderBy('id', 'desc')->get();
        };

        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        $dpms = department::all();
        // dd($gendoc);
        return view('/tables/projTable', compact('inspectors','approvers','gendoc', 'user','dpms'));
    }

    // query all anno form from database to anno table page
    public function annoTable() {
        if ((Auth::user()->hasRole('employee')) && (((department::find((Auth::user())->dpm))->prefix == 'IDD') || ((department::find((Auth::user())->dpm))->prefix == 'INS'))) {
            $gendoc = announce_doc::where('dpm', (department::find((Auth::user())->dpm))->prefix)->orWhere('dpm', 'LIKE', '%'.((department::find((Auth::user())->dpm))->prefix).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orderBy('id', 'desc')->get();
        }
        elseif (Auth::user()->hasRole('employee')) {
            $gendoc = announce_doc::where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orderBy('id', 'desc')->get();
        }
        elseif (Auth::user()->hasRole('leader_dpm')) {
            $gendoc = announce_doc::where('submit_by', 'LIKE', '%'.((Auth::user())->id).'%')->orWhere('shares', 'LIKE', '%"'.((Auth::user())->dpm).'"%')->orWhere('dpm', (department::find((Auth::user())->dpm))->prefix)->orderBy('id', 'desc')->get();
        }
        else {
            $gendoc = announce_doc::orderBy('id', 'desc')->get();
        };

        foreach($gendoc as $doc) {
            if ($doc->dpm === '-'){
                $usersub = json_decode($doc->submit_by);
                $doc->dpm = (department::find((User::find(is_array($usersub) ? $usersub[0] : $doc->submit_by))->dpm))->prefix;
                $doc->save();
            }
        };
        $user = User::all();
        $approvers = User::permission('approve')->get();
        $inspectors = User::permission('inspect')->get();
        // dd($gendoc);
        $dpms = department::all();
        return view('/tables/annoTable', compact('inspectors','approvers','gendoc', 'user', 'dpms'));
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
                    ->orderBy('id', 'desc')->get();
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
            if ($request->type === 'proj') {
                $gendoc = project_doc::find($request->bid);
            } elseif ($request->type === 'cont') {
                $gendoc = Contract::find($request->bid);
            } else {
                $gendoc = gendoc::find($request->bid);
            }
            $gendoc->submit_by = $data;
            $gendoc->save();

            Alert::toast('team has been saved!','success');
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
            if ($request->type === 'proj') {
                $gendoc = project_doc::find($request->bid);
            } elseif ($request->type === 'cont') {
                $gendoc = Contract::find($request->bid);
            } else {
                $gendoc = gendoc::find($request->bid);
            }
            $gendoc->submit_by = $data;
            $gendoc->save();

            Alert::toast('Team has been cleared!','success');
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function uploadFile(Request $request) {

        try {
            // Validate the request
            $request->validate([
                'file' => 'required|mimes:pdf,jpg,jpeg,png,docx,doc,mp4,xlsx',
                'valueid' => 'required',
            ]);
            $destinationPath = 'files/';
            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $request->type.str_replace(' ', '', $file->getClientOriginalName());
                $file->move($destinationPath, $fileName);
            } else {
                return response()->json(['error' => 'File not found'], 400);
            }
            $fileList = [];
            if ($request->type == 'proj') {
                $yourModel = project_doc::find($request->input('valueid'));
                $fileData = json_decode($yourModel->files);
            } elseif ($request->type == 'announce') {
                $yourModel = announce_doc::find($request->input('valueid'));
                $fileData = json_decode($yourModel->files);
            } elseif ($request->type == 'mou') {
                $yourModel = mou_doc::find($request->input('valueid'));
                $fileData = json_decode($yourModel->files);
            } elseif ($request->type == 'cont') {
                $yourModel = Contract::find($request->input('valueid'));
                $fileData = $yourModel->files;
            } else {
                $yourModel = gendoc::find($request->input('valueid'));
                $fileData = json_decode($yourModel->files);
            }
            $fileList = $fileData;
            $fileList[] = $fileName;
            $yourModel->files = $fileList;
            $yourModel->save();

            return response()->json(['success' => $request->input('valueid')]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function deleteFile(Request $request) {
        try {
            // Handle file upload
            $filePath = $request->fileName; // Provide the relative path to the file

            if (Storage::disk('files')->exists($filePath)) {
                Storage::disk('files')->delete($filePath);
            } elseif (Storage::disk('files')->exists('contract/'.$filePath)) {
                Storage::disk('files')->delete('contract/'. $filePath);
            }
            $fileList = [];
            $finallist = [];
            if ($request->type == 'proj') {
                $yourModel = project_doc::find($request->input('id'));
                $fileData = json_decode($yourModel->files);
            } elseif ($request->type == 'announce') {
                $yourModel = announce_doc::find($request->input('id'));
                $fileData = json_decode($yourModel->files);
            } elseif ($request->type == 'mou') {
                $yourModel = mou_doc::find($request->input('id'));
                $fileData = json_decode($yourModel->files);
            } elseif ($request->type == 'cont') {
                $yourModel = Contract::find($request->input('id'));
                $fileData = $yourModel->files;
            } else {
                $yourModel = gendoc::find($request->input('id'));
                $fileData = json_decode($yourModel->files);
            }
            $fileList = $fileData;
            foreach ($fileList as $item) {
                if ($item !== $request->fileName) {
                    $finallist[] = $item;
                }
            }
            $yourModel->files = $finallist;
            $yourModel->save();

            return response()->json(['success' => $request->all()]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function saveSubtype (Request $request) {
        try {
            $type = $request->type;
            $subtype = $request->subtype;
            $type = type::create([
                'type' => $type,
                'subtype' => $subtype,
            ]);
            return response()->json(['saveSubtype' => "Success"]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function addShare (Request $request) {
        try {
            $fileList = [];
            if ($request->type == 'proj') {
                $yourModel = project_doc::find($request->input('bid'));
            } elseif ($request->type == 'anno') {
                $yourModel = announce_doc::find($request->input('bid'));
            } elseif ($request->type == 'mou') {
                $yourModel = mou_doc::find($request->input('bid'));
            } else {
                $yourModel = gendoc::find($request->input('bid'));
            }

            $share = $yourModel->shares;
            if ($share) {
                $fileList = json_decode($share);
            }
            $fileList[] = $request->memb;
            $yourModel->shares = $fileList;
            $yourModel->save();

            return response()->json($fileList);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function clearShare (Request $request) {
        try {
            if ($request->type == 'proj') {
                $yourModel = project_doc::find($request->input('bid'));
            } elseif ($request->type == 'anno') {
                $yourModel = announce_doc::find($request->input('bid'));
            } elseif ($request->type == 'mou') {
                $yourModel = mou_doc::find($request->input('bid'));
            } else {
                $yourModel = gendoc::find($request->input('bid'));
            }

            $yourModel->shares = null;
            $yourModel->save();

            return response()->json(['success' => 'clear share success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
}
