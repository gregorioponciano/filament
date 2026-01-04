<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DestroyProfileController extends Controller
{
        public function destroyProfile(Request $request, string $id)
    {
        $user = User::findOrFail($id);
       $user->delete();
       return back();
    }
}
