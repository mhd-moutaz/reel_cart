<?php

namespace App\Http\Controllers\delivery;

use App\Enums\StatusOrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Services\delivery\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderConrtoller extends Controller
{
    protected $orderservice;
    public function __construct(OrderService $orderService)
    {
        $this->orderservice = $orderService;
    }
    public function getAllOrdersProcessing()
    {
        return $this->orderservice->index();
    }
    public function confirm_Order(Order $order)
    {
        $order = $this->orderservice->chooseOrder($order);
        return response()->json(['massage' => 'The Order status changed!', new OrderResource($order)], 200);
    }
    public function showMyOrder(Order $order)
    {
        $order = $this->orderservice->show($order);
        return response()->json([new OrderResource($order)], 200);
    }
    public function updateMyOrder(Order $order, Request $request)
    {
        $order = $this->orderservice->updateStatusOrder($order, $request->only('status'));
        return response()->json([new OrderResource($order)], 200);
    }
}
