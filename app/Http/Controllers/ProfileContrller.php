<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileContrller extends Controller
{
    public function view(Request $request)
    {
        return view('profile.view');
    }
}
