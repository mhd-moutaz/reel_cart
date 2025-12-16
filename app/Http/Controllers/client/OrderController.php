<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\createOrderRequest;
use App\Http\Resources\client\CartResource;
use App\Http\Resources\client\OrderResource;
use App\Http\Services\client\OrderService;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderservice;
    public function __construct(OrderService $orderservice)
    {
        $this->orderservice = $orderservice;
    }
    public function create(createOrderRequest $request)
    {
        $cart = $this->orderservice->createOrder($request->validated());
        return $this->success(['Product added to cart successfully', new CartResource($cart)], 201);
    }
    public function index()
    {
        $order = $this->orderservice->showPendingOrderCart();
        return $this->success(['Cart showed successfully', new OrderResource($order)], 201);
    }
    public function showOrders()
    {
        $orders = $this->orderservice->getAllOrders();
        return $this->success(['Orders retrieved successfully', OrderResource::collection($orders)], 200);
    }
    public function deleteCart(Cart $cart)
    {
        $this->orderservice->removeCart($cart);
        return $this->success(['Cart item removed successfully'], 200);
    }
    public function confirm_order(Order $order)
    {
        $order = $this->orderservice->confirmOrder($order);
        return $this->success(['Order confirmed successfully', new OrderResource($order)], 200);
    }
    public function update_cart_quantity(Request $request, Cart $cart)
    {
        $cart = $this->orderservice->updateCartQuantity($cart, (int)$request->input('quantity'));
        return $this->success(['Cart item updated successfully', new CartResource($cart)], 200);
    }
    public function CancelOrder(Order $order)
    {
        $order = $this->orderservice->cancelOrder($order);
        return $this->success(['Order cancelled successfully', new OrderResource($order)], 200);
    }
}
