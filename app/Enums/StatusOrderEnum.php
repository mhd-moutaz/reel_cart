<?php
namespace App\Enums;
enum StatusOrderEnum{
    const Completed = 'completed';
    const Pending = 'pending';
    const Processing = 'processing';
    const Ready = 'ready';
    const Delivered = 'delivered';
    const Cancelled = 'cancelled';
}

