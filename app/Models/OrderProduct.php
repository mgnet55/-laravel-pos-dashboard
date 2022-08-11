<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $appends = [
        'total_price'
    ];

    public function getTotalPriceAttribute()
    {
        return $this->unit_price * $this->quantity;
    }
}
