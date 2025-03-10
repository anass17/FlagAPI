<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User();
        $user -> first_name = $request -> first_name;
        $user -> last_name = $request -> last_name;
        $user -> email = $request -> email;
        $user -> password = HASH::make($request -> password);
        $user -> save();

        return response()->json(['message' => 'User Successfully Registrered'], 201);
    }

    public function hello() {
        return response()->json(['message' => 'Great!'], 201);
    }
}
