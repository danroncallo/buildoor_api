<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        
        $user = User::findUserByEmail($request->email);

        if (!$user) {
            return response()->json(['success' => false,
                'message' => 'user not found'])
                ->setStatusCode(400);
        }

        if (Hash::check($request->password, $user->password) &&
            ($user->role_id == 1))
        {
            $token = $user->createToken('Buildoor Personal Access Client')->accessToken;
            return response()->json(['success' => true,
                'access_token' => $token]);
        }

        return response()->json(['success' => false,
            'message' => 'invalid credentials'])
            ->setStatusCode(401);
    }

    public function store(Request $request)
    {
                
    }

    public function profile(Request $request)
    {
        $user = User::findUserByToken($request->user()->id);
        return response()->json(['user' => $user]);
    }
}
