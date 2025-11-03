<?php
namespace App\Enums;
enum StatusOrderEnum{
    const Pending = 'pending';
    const Processing = 'processing';
    const Ready = 'ready';
    const Delivered = 'delivered';
    const Completed = 'completed';
    const Cancelled = 'cancelled';
}

