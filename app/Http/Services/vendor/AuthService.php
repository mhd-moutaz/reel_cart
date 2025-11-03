<?php

namespace App\Http\Services\vendor;

use App\Models\User;
use App\Enums\RoleUserEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function registerVendor(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone_number' => $data['phone_number'],
                'role' => RoleUserEnum::Vendor,
            ]);
            $vendor = $user->vendor()->create([
                'national_id' => $data['national_id'],
                'business_type' => $data['business_type'],
                'description' => $data['description'],
                'has_store' => $data['has_store'],
                
            ]);
            DB::commit();
            return $vendor;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Registration failed' );
        }
    }
    public function loginVendor(array $data)
    {
        $token = Auth::attempt($data);
        if (!$token) {
            return null;
        }
        return $token;
    }
    public function logoutVendor()
    {
        Auth::logout();
    }
}
