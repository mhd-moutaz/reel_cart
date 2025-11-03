<?php

namespace App\Http\Services\delivery;

use App\Enums\StatusOrderEnum;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Logging\OpenTestReporting\Status;

class OrderService
{
    public function index()
    {
        return Order::where('status', StatusOrderEnum::Processing)->paginate(10);
    }
    public function show($order)
    {
        return $order;
    }
    public function updateStatusOrder($order, array $data)
    {
        if ($data['status'] === StatusOrderEnum::Cancelled) {
            $order->status = StatusOrderEnum::Cancelled;
        } elseif ($data['status'] === StatusOrderEnum::Completed) {
            $order->status = StatusOrderEnum::Completed;
        } elseif ($data['status'] === StatusOrderEnum::Delivered) {
            $order->status = StatusOrderEnum::Delivered;
        } else {
            throw new \Exception('invalid status value');
        }
        return $order;
    }
    public function chooseOrder($order)
    {
        $order->delivery_id = Auth::id();
        $order->status = StatusOrderEnum::Ready;
        return $order;
    }
}
