<?php

namespace App\Http\Services\delivery;

use App\Enums\RoleUserEnum;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Throw_;

class AuthService
{
    public function registerDelivery(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone_number' => $data['phone_number'],
                'role' => RoleUserEnum::Delivery,
            ]);

            if (isset($data['image'])) {
                $image_path = $data['image']->store('delivery', 'public');
            }
            $delivery = $user->delivery()->create([
                'national_id' => $data['national_id'],
                'address' => $data['address'],
                'birth_date' => $data['birth_date'],
                'image' => $image_path,
            ]);

            DB::commit();
            return $delivery;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function loginDelivery(array $data)
    {
        $token = Auth::attempt($data);
        if (!$token) {
            throw new \Exception('Invalid credentials');
        }
        return $token;
    }
    public function logoutDelivery()
    {
        Auth::logout();
    }
}
