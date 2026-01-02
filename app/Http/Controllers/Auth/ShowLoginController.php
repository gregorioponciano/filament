<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowLoginController extends Controller
{
    public function showLogin() {
        if (Auth::check()) {
            return redirect('/user');
        }
        return view('auth.login');
    }
}
