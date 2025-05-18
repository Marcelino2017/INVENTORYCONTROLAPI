<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;
    protected $userService;

    public function __construct(
        \App\Services\AuthService $authService,
    ) {
        $this->authService = $authService;
    }


    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        $loginResponse = $this->authService->login($data);

        if (isset($loginResponse['error'])) {
            return response()->json($loginResponse['error'], 401);
        }

        return response()->json($loginResponse);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only('name', 'email', 'password', 'role');


        if (!Auth::check() && isset($data['role']) && $data['role'] === 'admin') {
            return response()->json(['message' => 'Only authenticated users can register as admin'], 403);
        }

        $registerResponse = $this->authService->register($data);

        if (isset($registerResponse['error'])) {
            return response()->json($registerResponse['error'], 500);
        }

        return response()->json($registerResponse);
    }

}
