<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {

        $creadentails = $request->validate([
            'email' => ['required' , 'email'], 
            'password' => ['required', 'min:8'],  // minimum 8 characters long
            'remember' => ['boolean']
        ]);
        $remmber = $creadentails['remmber'] ?? false;
        unset($creadentails['remmber']);

        if(!auth()->attempt($creadentails, $remmber)){
           return response([
             'message' => 'Email or password is incorrect'
           ], 422);
        }
        $user = Auth::user();   
        if(!$user->is_admin) {
            Auth::logout();
            return response([
                'message' => 'You don\'t have permission to access this page'
              ], 403);
            
        }

        $token = $user->createToken('main')->lainTextToken;
        // $token = $user->createToken('authToken')->plainTextToken;

        return response([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout() {
        // auth()->logout();
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->noContent(204);
    }
}
