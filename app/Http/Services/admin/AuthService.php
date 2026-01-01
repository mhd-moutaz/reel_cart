<?php

namespace App\Http\Services\Admin;

use App\Enums\RoleUserEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function loginAdmin(array $data)
    {
        // استخدم web guard بشكل صريح
        $credentials = array_merge($data, ['role' => RoleUserEnum::Admin]);

        if (Auth::guard('web')->attempt($credentials)) {
            return true;
        }

        throw new \Exception('Invalid credentials or unauthorized access');
    }
}
