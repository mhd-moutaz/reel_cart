<?php

namespace App\Http\Controllers\vendor\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Global\loginRequest;
use App\Http\Requests\vendor\registerRequest;
use App\Http\Services\vendor\auth\AuthService;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(registerRequest $request)
    {
        $vendor = $this->authService->registerVendor($request->validated());
        return response()->json([
            'message' => 'vendor successfully registered',
            'vendor' => $vendor
        ], 201);
    }

    public function login(loginRequest $request)
    {
        $token = $this->authService->loginVendor($request->validated());

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['vendor' => $token], 200);
    }

    public function logout()
    {
        $this->authService->logoutVendor();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}









