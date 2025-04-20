<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address', 'postal_code', 'status'];
    public function getTotalPriceAttribute()
    {
        return $this->orderDetails->sum('price');
    }

    protected $appends = ['total_price'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
