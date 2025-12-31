<?php

namespace App\Enums;

enum StatusOrderEnum
{
    const Pending = 'pending';
    const Processing = 'processing';
    const Completed = 'completed';
    const Cancelled = 'cancelled';
}
