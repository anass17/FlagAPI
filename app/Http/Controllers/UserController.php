<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index() {

        $users = User::all();

        return response()->json(['users' => $users], 200);

    }

    public function show($id) {

        $user = User::find((int) $id);

        if ($user) {
            return response()->json(['status' => 'success', 'user' => $user], 200);
        }
        
        return response()->json(['status' => 'failed', 'message' => 'User not found'], 404);

    }
}
