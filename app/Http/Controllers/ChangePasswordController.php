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
        // Show ChangePassword page
        return view('auth/passwords/reset', compact('id'));
    }

    public function changePassword(Request $request, $id)
    {
        // แทนที่ assword เดิมด้วย password ใหม่
        $user = Auth::user();

        // หน้าเป็น admin ไม่ต้องใส่ pass เดิม
        if ($user->hasRole('admin')) {
            $userPassChange = User::find($id);
            $userPassChange->update([
                'password' => Hash::make($request->new_password),
            ]);
            Alert::toast('Password updated successfully!','success');
            return redirect()->route('home');
        }

        // validate password ที่กรอกมา
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // ถ้ากรอก pass เดิมถูกต้อง -> แทนที่ด้วย pass ใหม่
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            Alert::toast('Password updated successfully!','success');
            return redirect()->route('alluser');
        }
        return redirect()->route('changepassword')->with('error', 'Current password is incorrect.');
    }
}
