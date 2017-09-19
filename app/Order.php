<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
