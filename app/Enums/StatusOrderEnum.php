<?php
namespace App\Enums;
enum StatusOrderEnum{
    const Draft = 'draft';
    const Pending = 'pending';
    const Processing = 'processing';
    const Ready = 'ready';
    const Delivered = 'delivered';
    const Cancelled = 'cancelled';
}

