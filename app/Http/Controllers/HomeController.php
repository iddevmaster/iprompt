<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\agencie;
use App\Models\branche;
use App\Models\department;
use App\Models\User;
use App\Models\type;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\user_problem;
Use Alert;
use App\Models\Contract;
use App\Models\ProjectCode;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Catch_;

class HomeController extends Controller
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
        $contracts = Contract::where('by', auth()->user()->id)->orderBy('id', 'desc')->get();

        foreach ($contracts as $index => $contract) {
            $dateArray = explode(' - ', $contract->time_range);
            $endDate = Carbon::createFromFormat('d/m/Y', $dateArray[1]);
            $currentDate = Carbon::now();

            // Calculate 7 days before the end date
            $sevenDaysBeforeEndDate = $endDate->copy()->subDays(7);

            if ($currentDate->isBetween($sevenDaysBeforeEndDate, $endDate)) {
                $contract->alert = 1;
            } else {
                $contract->alert = 0;
            }

            $contract->save();

        }
        return view('home', compact('contracts'));
    }

    public function createUser()
    {
        return view('auth/register');
    }

    public function profile() {
        $user = Auth::user();
        $permissions = Permission::all();
        $agn = agencie::all();
        $brn = branche::all();
        $dpm = department::all();
        $role = Role::all();
        return view('profile', compact('role','user', 'permissions', 'agn', 'brn', 'dpm'));
    }

    public function management() {
        $permis = Permission::all();
        $roles = Role::all();
        $agen = agencie::all();
        $branch = branche::all();
        $dpms = department::all();
        return view('management', compact('permis', 'roles', 'agen', 'branch', 'dpms'));
    }

    public function alluser() {
        $user = User::orderBy('id', 'desc')->get();
        $agn = agencie::all();
        $brn = branche::all();
        $dpm = department::all();
        return view('userTable', compact('user', 'agn', 'brn', 'dpm'));
    }

    public function userProfile(Request $request, $id) {

        $user = User::firstWhere('id', $id);
        $permissions = Permission::all();
        $agn = agencie::all();
        $brn = branche::all();
        $dpm = department::all();
        $role = Role::all();
        return view('profile', compact('role','user', 'permissions', 'agn', 'brn', 'dpm'));
    }

    public function storeUser(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'agency' => $request->agency,
            'branch' => $request->branch,
            'phone' => $request->phone,
            'dpm'  => $request->dpm,
        ]);
        $role = Role::where('name', $request->role)->first();
        if ($user && $role) {
            $user->assignRole($role);
            $user->save();

            // Role 'admin' has been assigned to the user
        } else {
            // User or role not found, handle the error accordingly
        }
        Alert::toast('User added successfully!','success');
        return redirect()->route('alluser');
    }

    public function updateUser(Request $request)
    {
        $data = $request->all();
        $log = [];
        $user = User::find($data['id']);
        try {
            $permiss = json_decode($data['permiss']);
            foreach ($permiss ?? [] as $key => $value) {
                if ($value){
                    $log[] = 'if ' . $key;
                    $user->givePermissionTo($key);
                } else {
                    $log[] = 'else ' . $key;
                    $user->revokePermissionTo($key);
                }
            }

            $destinationPath = 'files/signs/';
            // Handle file upload
            if ($request->hasFile('sign')) {
                $file = $request->file('sign');
                $fileName = $user->email . '.' . $file->getClientOriginalExtension();
                // if file size is over 5MB not upload
                if ($file->getSize() < 5 * 1024 * 1024) {
                    // if has same name file, delete it
                    if (file_exists($destinationPath . $fileName)) {
                        unlink($destinationPath . $fileName);
                    }
                    $file->move($destinationPath, $fileName);
                    $user->image = $fileName;
                }
            }

            $user->name = $data['name'];
            $user->email = $data['username'];
            $user->agency = $data['agn'];
            $user->branch = $data['brn'];
            $user->phone = $data['phone'];
            $user->dpm = $data['dpm'];
            $user->syncRoles([$data['role']]);
            $user->role = $data['role'];

            $user->save();
            Alert::toast('User update successfully!','success');
            return response()->json(['data' => $request->hasFile('sign'), 'log' => $log, 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'data is not save']);
        }
    }

    public function addPermis (Request $request) {
        try {
            Permission::create(['name' => $request->value]);
            Alert::toast('User added successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function delPermis (Request $request) {
        try {
            $permission = Permission::findByName($request->value);
            if ($permission->roles()->count() === 0) {
                $permission->delete();
                Alert::toast('User added successfully!','success');
                return response()->json(['success' => 'success']);
            } else {
                Alert::toast('Permission has role!','error');
                return response()->json(['success' => 'permission has role']);
            }

        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function delType (Request $request) {
        try {
            $deltype = type::find($request->value);
            if ($deltype) {
                $deltype->delete();
            }
            Alert::toast('Type has Del!','success');
            return response()->json(['success' => 'type has del']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function saveIssue (Request $request) {
        try {
            user_problem::create([
                'user_id' => Auth::user()->id,
                'prob_datail' => $request->value,
                'user_contact' => '-',
            ]);
            return response()->json(['success' => $request->value]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function issueReport (Request $request) {
        $wait_issues = user_problem::where('status', 'waiting')->get();
        $success_issue = user_problem::where('status', 'Successed')->get();
        return view('issue', compact('wait_issues', 'success_issue'));
    }

    public function issueFixed (Request $request) {
        try {
            $issue = user_problem::find($request->value);
            $issue->status = "Successed";
            $issue->save();
            Alert::toast('Issue is clear!','success');
            return response()->json(['success' => $request->value]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function addRole (Request $request) {
        try {
            Role::create(['name' => $request->value]);
            Alert::toast('Added role successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function addAgn (Request $request) {
        try {
            agencie::create(['name' => $request->value]);
            Alert::toast('Added agencie successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function delAgn (Request $request) {
        try {
            agencie::where('name', $request->value)->delete();
            Alert::toast('Deleted agencie successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function addBrn (Request $request) {
        try {
            branche::create(['name' => $request->value, 'agency_id' => $request->brnagn]);
            Alert::toast('Added agencie successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function delBrn (Request $request) {
        try {
            branche::where('name', $request->value)->delete();
            Alert::toast('Deleted agencie successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function addDpm (Request $request) {
        try {
            department::create(['name' => $request->value, 'branch_id' => $request->brnagn, 'prefix' => $request->prefix]);
            Alert::toast('Added agencie successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function delDpm (Request $request) {
        try {
            department::where('name', $request->value)->delete();
            Alert::toast('Deleted agencie successfully!','success');
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function delRole (Request $request) {
        try {
            $role = Role::findByName($request->value);
            if ($role->permissions()->count() === 0) {
                $role->delete();
                Alert::toast('Delete role successfully!','success');
                return response()->json(['success' => 'success']);
            } else {
                Alert::toast('Permission has role!','error');
                return response()->json(['success' => 'permission has role']);
            }

        } catch (\Exception $e) {
            Alert::toast('error!','error');
            return response()->json(['error' => $e]);
        }
    }

    public function contract() {
        $currentYear = now()->year;
        $ctcre_count = Contract::where('type', 'creditor')->whereYear('created_at', $currentYear)->count();
        $ctdeb_count = Contract::where('type', 'debtor')->whereYear('created_at', $currentYear)->count();
        $ctotd_count = Contract::where('type', 'outdoor')->whereYear('created_at', $currentYear)->count();
        $projCodes = ProjectCode::orderBy('id', 'desc')->get();
        return view('forms.contract', compact('ctcre_count', 'ctdeb_count', 'ctotd_count', 'projCodes'));
    }

    public function editContract($cid) {
        $contract = Contract::find($cid);
        $projCodes = ProjectCode::orderBy('id', 'desc')->get();
        return view('forms.edit-contract', compact('contract', 'projCodes'));
    }
}
