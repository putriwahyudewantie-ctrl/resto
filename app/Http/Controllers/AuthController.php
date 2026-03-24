<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Form Register
    public function showRegister() {
        return view('register');
    }

    // Submit Register
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => md5($request->password),
        ]);

        return redirect('/login')->with('success', 'Register berhasil!');
    }

    // Form Login
    public function showLogin() {
        return view('login');
    }

    // Submit Login
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('password', md5($request->password))
                    ->first();

        if($user){
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            return redirect('/dashboard');
        } else {
            return back()->with('error', 'Email atau password salah!');
        }
    }

    // Logout
    public function logout() {
        Session::flush();
        return redirect('/login');
    }
}