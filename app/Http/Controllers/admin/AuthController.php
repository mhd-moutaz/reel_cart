<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\AuthService;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        return view('admin.users', compact('users'));
    }
    public function showVendorsForm()
    {
        $users = Vendor::get();
        return view('admin.vendors', compact('users'));
    }
    // في Controller
    public function updateVendorVerification(Request $request, $userId)
    {
        try {
            $request->validate([
                'verification_status' => 'required|in:pending,verified,rejected'
            ]);

            $vendor = Vendor::findOrFail($userId);
            $vendor->verification_status = $request->verification_status;
            $vendor->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة التحقق بنجاح',
                'verification_status' => $vendor->verification_status
            ]);
        } catch (\Exception $e) {
            Log::error('Verification update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التحديث'
            ], 500);
        }
    }
    public function showStoresForm()
    {
        $stores = Store::get();
        return view('admin.Store', compact('stores'));
    }
    // في StoreController أو Controller المناسب
    public function updateVerification(Request $request, $storeId)
    {
        try {
            $request->validate([
                'is_verified' => 'required|boolean'
            ]);

            $store = Store::findOrFail($storeId);
            $store->is_verified = $request->is_verified;
            $store->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة التحقق بنجاح',
                'is_verified' => $store->is_verified
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التحديث'
            ], 500);
        }
    }
    public function showDashboardForm()
    {
        $products = Product::get();
        $vendors = Vendor::get();
        $clients = Client::get();
        $orders = Order::get();
        $stores = Store::get();
        return view('admin.dashboard', compact(['products', 'vendors', 'clients', 'orders', 'stores']));
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => \App\Enums\RoleUserEnum::Admin,
        ];

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة أو ليس لديك صلاحيات الدخول.',
        ])->withInput($request->except('password'));
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.dashboard');
    }
}
