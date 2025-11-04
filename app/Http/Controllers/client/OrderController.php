<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\createOrderRequest;
use App\Http\Resources\client\CartResource;
use App\Http\Resources\client\OrderResource;
use App\Http\Services\client\OrderService;
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
        $order = $this->orderservice->showOrderCart();
        return $this->success(['Cart showed successfully', new OrderResource($order)], 201);
    }
}
