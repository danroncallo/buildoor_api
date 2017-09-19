<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $hidden = ['product_tax', 'created_at', 'updated_at'];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
