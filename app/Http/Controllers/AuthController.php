<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required' , 'email'], 
            'password' => ['required', 'min:8'],  // minimum 8 characters long
            'remember' => ['boolean']
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if(!Auth::attempt($credentials, $remember)){
           return response([
             'message' => 'Email or password is incorrect'
           ], 422);
        }

        /** @var \App\Models\User $user */
         
        $user = Auth::user();   
        if(!$user->is_admin) {
            Auth::logout();
            return response([
                'message' => 'You don\'t have permission to access this page'
              ], 403);
            
        }

        $token = $user->createToken('main')->plainTextToken;
        // $token = $user->createToken('main')->plainTextToken;
        // $token = $user->createToken('authToken')->plainTextToken;
        // $token = $user->createToken('main', ['*'], now()->addDays(7))->plainTextToken;

        return response([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout() {
         dd('test');
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->currentAccessToken->delete();
        // $user->tokens()->delete(); 
        return response('', 204);
    }

    public function getUser(Request $request)
    {
        dd($request->all());
        return new UserResource($request->user());
    }
}
