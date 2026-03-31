<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $admin = Admin::where('email', $request->email)->first();

    if($admin && Hash::check($request->password, $admin->password)){

        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name
        ]);

        return redirect()->route('dashboard');
    }

    return back()->with('error', 'Invalid login credentials');
}
    public function logout()
    {
        session::forget('admin_id');

        return redirect()->route('login');
    }
}

