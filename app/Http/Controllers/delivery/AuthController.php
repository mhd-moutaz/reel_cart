<?php

namespace App\Http\Controllers\delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\registerRequest;
use App\Http\Requests\delivery\RegisterDeliveryRequest;
use App\Http\Requests\Global\loginRequest;
use App\Http\Resources\client\DeliveryloginregisterResource;
use App\Http\Services\delivery\AuthService;
use App\Models\Delivery;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterDeliveryRequest $request)
    {
        $delivery = $this->authService->registerDelivery($request->validated());
        return response()->json(['message' => 'Delivery registered successfully', new DeliveryloginregisterResource($delivery)], 201);
    }
    public function login(loginRequest $request)
    {
        $token = $this->authService->loginDelivery($request->validated());
        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return response()->json(['message' => 'Delivery logged in successfully', 'token' => $token], 200);
    }
    public function logout()
    {
        $this->authService->logoutDelivery();
        return response()->json(['message' => 'Delivery Logged out successfully'], 200);
    }
}
