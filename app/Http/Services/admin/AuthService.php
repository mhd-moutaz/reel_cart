<?php

namespace App\Http\Services\Admin;

use App\Enums\RoleUserEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function loginAdmin(array $data)
    {
        // إضافة شرط الـ role في عملية المصادقة
        $credentials = array_merge($data, ['role' => RoleUserEnum::Admin]);

        $token = Auth::attempt($credentials);
        if (!$token) {
            throw new \Exception('Invalid credentials or unauthorized access');
        }

        return $token;
    }
}
