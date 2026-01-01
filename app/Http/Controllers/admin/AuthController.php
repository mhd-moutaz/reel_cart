<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\AuthService;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function showLoginForm()
    {
        return view('login');
    }
    // public function showDashboardForm()
    // {
    //     return view('admin.dashboard');
    // }
    public function showUsersForm()
    {
        $users = Client::get();
        return view('admin.users',compact('users'));
    }
    public function showDashboardForm()
    {
        $products = Product::get();
        $vendors = Vendor::get();
        $clients = Client::get();
        $orders = Order::get();
        $ordersCount= Order::get();
        return view('admin.dashboard', compact(['products', 'vendors', 'clients', 'orders']));
    }
    public function login(Request $request)
    {
        $this->authService->loginAdmin($request->only('email', 'password'));
        return redirect()->route('admin.dashboard');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.dashboard');
    }
}
