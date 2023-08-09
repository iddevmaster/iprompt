<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use Alert;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm($id)
    {
        return view('auth/passwords/reset', compact('id'));
    }

    public function changePassword(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $userPassChange = User::find($id);
            $userPassChange->update([
                'password' => Hash::make($request->new_password),
            ]);
            Alert::toast('Password updated successfully!','success');
            return redirect()->route('home');
        }
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);


        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            Alert::toast('Password updated successfully!','success');
            return redirect()->route('home');
        }
        return redirect()->route('changepassword')->with('error', 'Current password is incorrect.');
    }
}
