<?php

namespace App\Http\Controllers\delivery;

use App\Enums\StatusOrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\delivery\OrderResource;
use App\Http\Services\delivery\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderservice;
    public function __construct(OrderService $orderService)
    {
        $this->orderservice = $orderService;
    }
    public function getAllOrdersProcessing()
    {
        $orders = $this->orderservice->index();
        return response()->json(['orders' => OrderResource::collection($orders)], 200);
    }
    public function confirm_Order(Order $order)
    {
        $order = $this->orderservice->chooseOrder($order);
        return response()->json(['massage' => 'The Order status changed!', 'order' => new OrderResource($order)], 200);
    }
    public function showMyOrder(Order $order)
    {
        $order = $this->orderservice->show($order);
        return response()->json([new OrderResource($order)], 200);
    }
    public function updateMyOrder(Order $order)
    {
        $order = $this->orderservice->updateStatusOrder($order);
        return response()->json([new OrderResource($order)], 200);
    }
    public function cancelOrder(Order $order)
    {
        $order = $this->orderservice->cancelOrder($order);
        return response()->json(['message' => 'The Order has been cancelled!', 'order' => new OrderResource($order)], 200);
    }
}
