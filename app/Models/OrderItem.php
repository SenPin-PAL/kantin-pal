<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price_per_item'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

     public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
