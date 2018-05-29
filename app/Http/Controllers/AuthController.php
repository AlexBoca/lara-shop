<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        $name = $_POST["username"];
        $password = $_POST["password"];
        if (env('ADMIN_USERNAME') == $name && env('ADMIN_PASSWORD') == $password) {
            session()->push('user_login', true);
            return redirect()->back();
        }
        return redirect()->route('products');
    }

    public function logout()
    {
        session()->forget('user_login');
        return redirect()->route('login');
    }

    public function loginForm()
    {
        return view('login');
    }
}
