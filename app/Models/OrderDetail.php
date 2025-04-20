<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity'];

    protected $appends = ['price'];

    public function getPriceAttribute()
    {
        if ($this->product->discount) {
            return $this->product->discounted_price * $this->quantity;
        }
        return $this->product->price * $this->quantity;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
