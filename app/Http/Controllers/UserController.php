<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //show all users
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }

    //register
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            'result' => true,
            'msg' => 'Account created successfully',
            'user' => $user
        ], 201);
    }

    //show specific user
    public function show(Request $request){
        $user = $request->user();
        return response()->json([
            'result' => true,
            'msg' => 'User found successfully',
            'user' => $user
        ]);
    }
    // public function show(User $id)
    // {
    //     return response()->json([
    //         'result' => true,
    //         'msg' => 'User found successfully',
    //         'user' => $id
    //     ]);
    // }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'result' => false,
                'msg' => 'Invalid email or password'
            ], 401);
        }

        // Generate and save remember_token
        // $rememberToken = Str::random(80);
        // $user->remember_token = $rememberToken;
        // $user->save();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'result' => true,
            'msg' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    //logout
    public function logout(Request $request){
        //delete current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['msg'=> 'Logged out successfully'], 200);
    }
}