<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address', 'postal_code', 'authority'];

    public function getTotalPriceAttribute()
    {
        return $this->orderDetails->sum('price');
    }

    public function getStatusAttribute()
    {
        return $this->orderDetails()->where('status', false)->count() > 0 ? "Done" : "Pending";
    }

    protected $appends = ['total_price', 'status'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
