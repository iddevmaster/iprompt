<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\agencie;
use App\Models\branche;
use App\Models\department;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
Use Alert;


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
        return view('home');
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

    public function alluser() {
        $user = User::orderBy('id', 'desc')->paginate(10);
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
        $user = User::find($data['id']);
        try {
            if ($data['approver']){
                $user->givePermissionTo('approve');
            } else {
                $user->revokePermissionTo('approve');
            }
            if ($data['inspector']){
                $user->givePermissionTo('inspect');
            } else {
                $user->revokePermissionTo('inspect');
            }
            if ($data['wi']){
                $user->givePermissionTo('WI');
            } else {
                $user->revokePermissionTo('WI');
            }
            if ($data['sop']){
                $user->givePermissionTo('SOP');
            } else {
                $user->revokePermissionTo('SOP');
            }
            if ($data['pol']){
                $user->givePermissionTo('POL');
            } else {
                $user->revokePermissionTo('POL');
            }
            if ($data['proj']){
                $user->givePermissionTo('PRO');
            } else {
                $user->revokePermissionTo('PRO');
            }
            if ($data['mou']){
                $user->givePermissionTo('MOU');
            } else {
                $user->revokePermissionTo('MOU');
            }
            if ($data['anno']){
                $user->givePermissionTo('ANNO');
            } else {
                $user->revokePermissionTo('ANNO');
            }
            if ($data['cont']){
                $user->givePermissionTo('CONT');
            } else {
                $user->revokePermissionTo('CONT');
            }
            if ($data['download'] === '1'){
                $user->givePermissionTo('download');
            } else {
                $user->revokePermissionTo('download');
            }
            if ($data['create'] === '1'){
                $user->givePermissionTo('create');
            } else {
                $user->revokePermissionTo('create');
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
            
            return response()->json(['data' => $data, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['message' => "Changes are not saved!"]);
        }
    }
}
