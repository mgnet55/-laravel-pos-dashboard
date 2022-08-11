<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS = [
        '0' => 'Pending',
        '1' => 'Prepared',
        '2' => 'Delivering',
        '3' => 'Delivered',
        '4' => 'Cancelled'
    ];

    /* Relations */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['unit_price', 'quantity'])->using(OrderProduct::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->products->sum('pivot.total_price');
    }

    public function getTotalProductsAttribute()
    {
        return $this->products->sum('pivot.quantity');
    }

    public function getStatusAttribute($value)
    {
        return $this::STATUS[$value];
    }

}
