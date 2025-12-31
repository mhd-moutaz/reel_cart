<?php

namespace App\Http\Services\client;

use App\Enums\StatusOrderEnum;
use App\Exceptions\GeneralException;
use App\Http\Controllers\vendor\product\ProductController;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $productController;
    public function __construct(ProductController $productController)
    {
        $this->productController = $productController;
    }
    //-----------------------------------------------------------------------------------------------------------------Cart
    public function removeCart($cart)
    {
        $order = $cart->order;
        $order->total_price -= $cart->sub_total;
        $order->save();
        $cart->delete();
        return true;
    }
    public function updateCartQuantity(Cart $cart, int $quantity)
    {
        $product = Product::find($cart->product_id);
        if ($quantity > $product->quantity) {
            throw new GeneralException('Product stock not available for the requested quantity.');
        }
        $order = $cart->order;
        $order->total_price -= $cart->sub_total;
        $cart->quantity = $quantity;
        $cart->sub_total = $quantity * $cart->unit_price;
        $cart->save();
        $order->total_price += $cart->sub_total;
        $order->save();
        return $cart;
    }
    //-----------------------------------------------------------------------------------------------------------------Order
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
    public function showPendingOrderCart()
    {
        $client = Client::where('user_id', Auth::id())->first();
        if (!$client) {
            throw new GeneralException('Client not found for this user.', 404);
        }
        $order = Order::where('client_id', $client->id)
            ->where('status', StatusOrderEnum::Pending)
            ->first();
        if (!$order) {
            throw new GeneralException('you have no Order, please go and add to your cart', 404);
        }
        return $order;
    }
    public function confirmOrder()
    {
        DB::beginTransaction();
        try {
            $order = Order::where('client_id', Client::where('user_id', Auth::id())->first()->id)
                ->where('status', StatusOrderEnum::Pending)
                ->first();
            if (!$order) {
                throw new GeneralException('No pending order found to confirm.', 404);
            }
            $cart_items = Cart::where('order_id', $order->id)->get();
            if ($cart_items->isEmpty()) {
                throw new GeneralException('Cannot confirm an empty order.');
            } else {
                foreach ($cart_items as $item) {
                    $product = Product::find($item->product_id);
                    $this->productController->changeStatus($product, $item->quantity);
                }
            }
            $order->status = StatusOrderEnum::Processing;
            $order->save();
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function getAllOrders()
    {
        $client = Client::where('user_id', Auth::id())->first();
        $orders = Order::where('client_id', $client->id)->get();
        return $orders;
    }
    public function cancelOrder($order)
    {
        if ($order->status === StatusOrderEnum::Pending) {
            $order->status = StatusOrderEnum::Cancelled;
            $order->save();
            return $order;
        } else {
            throw new GeneralException('Only pending orders can be cancelled.', 400);
        }
    }
}
