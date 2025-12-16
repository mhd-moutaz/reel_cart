<?php

namespace App\Http\Services\delivery;

use App\Enums\StatusOrderEnum;
use App\Exceptions\GeneralException;
use App\Models\Delivery;
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
        $order->load(['client', 'delivery']);
        $delivery = Delivery::where('user_id', Auth::id())->first();
        if ($order->delivery_id == $delivery->id) {
            if ($order->status === StatusOrderEnum::Cancelled)
                throw new GeneralException('you don\'\t have any main Orders , please go and select an order .');
            else {
                return $order;
            }
        } else {
            throw new GeneralException('You are not assigned to this order');
        }
    }
    public function updateStatusOrder($order)
    {
        $delivery = Delivery::where('user_id', Auth::id())->first();
        if ($order->delivery_id === $delivery->id) {
            if ($order->status === StatusOrderEnum::Ready) {
                $order->status = StatusOrderEnum::Completed;
            } elseif ($order->status === StatusOrderEnum::Completed) {
                $order->status = StatusOrderEnum::Delivered;
            } else {
                throw new GeneralException('invalid status value');
            }
            $order->save();
            return $order;
        } else {
            throw new GeneralException('You are not assigned to this order');
        }
    }
    public function cancelOrder($order)
    {
        $delivery = Delivery::where('user_id', Auth::id())->first();
        if ($order->delivery_id === $delivery->id) {
            $order->status = StatusOrderEnum::Cancelled;
            $order->save();
            return $order;
        } else {
            throw new GeneralException('You are not assigned to this order');
        }
    }
    public function chooseOrder($order)
    {
        $delivery = Delivery::where('user_id', Auth::id())->first();
        if ($order->status === StatusOrderEnum::Processing) {
            $order->delivery_id = $delivery->id;
            $order->status = StatusOrderEnum::Ready;
            $order->save();
            return $order;
        } else {
            throw new GeneralException('The order status is not processing');
        }
    }
}
