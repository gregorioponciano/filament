<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowProfileController extends Controller
{
    public function showProfile() {
        $user = Auth::user();
        $enderecos = $user->enderecos;
        return view('user.profile', compact('user', 'enderecos'));
    }
}   
