<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required' , 'email'], 
            'password' => ['required', 'min:8'],  // minimum 8 characters long
            // 'remember' => ['boolean']
        ]);
        $remmber = $credentials['remmber'] ?? false;
        unset($credentials['remmber']);

        if(!Auth::attempt($credentials, $remmber)){
           return response([
             'message' => 'Email or password is incorrect'
           ], 422);
        }
        /*
         * @var \App\Models\User $user
         */
        $user = Auth::user();   
        if(!$user->is_admin) {
            Auth::logout();
            return response([
                'message' => 'You don\'t have permission to access this page'
              ], 403);
            
        }

        $token = $user->createToken('main')->plainTextToken;
        // $token = $user->createToken('authToken')->plainTextToken;

        return response([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout() {
        // auth()->logout();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
