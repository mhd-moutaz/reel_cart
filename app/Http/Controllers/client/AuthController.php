<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\registerRequest;
use App\Http\Requests\Global\loginRequest;
use App\Http\Resources\client\ClientloginregisterResource;
use App\Http\Services\client\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(registerRequest $request)
    {
        $client = $this->authService->registerClient($request->validated());
        return response()->json(['message' => 'Client registered successfully', new ClientloginregisterResource($client)], 201);
    }
    public function login(loginRequest $request)
    {
        $token = $this->authService->loginClient($request->validated());
        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return response()->json(['message' => 'Client logged in successfully', 'token' => $token], 200);
    }
    public function logout()
    {
        $this->authService->logoutClient();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    public function showProfileDetails()
    {
        $profile = $this->authService->Profile();
        return response()->json(['message' => 'Profile details retrieved successfully', 'profile' => $profile], 200);
    }
}
