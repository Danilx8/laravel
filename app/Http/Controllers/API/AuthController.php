<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:App\Models\User,email',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $token = $user->createToken('MyAppTokens')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        if (Auth::attempt($credentials, $request->remember)){
            $token = auth()->user()->createToken('MyAppTokens')->plainTextToken;
            return response()->json([
                'token'=>$token,
                'user'=>auth()->user()
            ]);
        }

        return response()->json([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response('logout');
    }
}
