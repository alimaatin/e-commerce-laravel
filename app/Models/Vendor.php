<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'owner_id',
        'status'
    ];

    protected $appends = ['owner_name'];

    public function getOwnerNameAttribute()
    {
            return $this->owner->name;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Reservation::class);
    }
}
