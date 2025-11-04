<?php

namespace App\Http\Services\client;

use App\Enums\StatusOrderEnum;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $data)
    {
        DB::beginTransaction();

        try {
            $client = Client::where('user_id', Auth::id())->first();
            if (!$client) {
                throw new \Exception('Client not found for this user.');
            }

            $order = Order::where('client_id', $client->id)
                ->where('status', StatusOrderEnum::Pending)
                ->first();

            if (!$order) {
                $order = Order::create([
                    'client_id' => $client->id,
                ]);
            }

            $product = Product::find($data['product_id']);

            if (!$product) {
                throw new \Exception('Product not found.');
            }
            if ($data['quantity'] > $product->quantity) {
                throw new \Exception('Product stock not available.');
            }

            $check_cart = Cart::where('order_id', $order->id)
                ->where('product_id', $product->id)
                ->first();
            if ($check_cart) {
                throw new \Exception('Product already in cart, please update quantity instead.');
            }
            $cart = Cart::create([
                'order_id'   => $order->id,
                'product_id' => $data['product_id'],
                'quantity'   => $data['quantity'],
                'unit_price' => $product->price,
                'sub_total'  => $data['quantity'] * $product->price,
            ]);
            $order->total_price += $cart->sub_total;
            $order->save();
            DB::commit();
            return $cart;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function showOrderCart()
    {
        $client = Client::where('user_id', Auth::id())->first();
        if (!$client) {
            throw new \Exception('Client not found for this user.');
        }
        $order = Order::where('client_id', $client->id)
            ->where('status', StatusOrderEnum::Pending)
            ->first();
        if (!$order) {
            throw new \Exception('you have no Order, please go and add to your cart');
        }
        return $order;
    }
}
