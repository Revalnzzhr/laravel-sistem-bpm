<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        
        if ($username === 'Admin' && $password === 'password') {
           
            Cookie::queue('username', $username, 60);

            
            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah!');
        }
    }
}
