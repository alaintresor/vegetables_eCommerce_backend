<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    //
    public function register(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = $user->createToken('authToken')->plainTextToken;
        $res = [
            'token' => $token,
            'user' => $user
        ];
        return Response()->json($res, 200);
    }
    public function login(Request $request)
    {
        //
        $this->validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return Response()->json(['message' => 'User not found'], 404);
        }
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('authToken')->plainTextToken;
            $res = [
                'token' => $token,
                'user' => $user
            ];
            return Response()->json($res, 200);
        } else {
            return Response()->json(['message' => 'Password is incorrect'], 404);
        }
    }
}
