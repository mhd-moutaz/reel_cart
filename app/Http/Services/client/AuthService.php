<?php

namespace App\Http\Services\client;

use App\Enums\RoleUserEnum;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Throw_;

class AuthService
{
    public function registerClient(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone_number' => $data['phone_number'],
                'role' => RoleUserEnum::Client,
            ]);

            $client = $user->client()->create([
                'birth_date' => $data['birth_date'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'image' => $data['image'],
            ]);

            DB::commit();
            return $client;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function loginClient(array $data)
    {
        $token = Auth::attempt($data);
        if (!$token) {
            throw new \Exception('Invalid credentials');
        }
        return $token;
    }
    public function logoutClient()
    {
        Auth::logout();
    }
}
