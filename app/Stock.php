<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $hidden=['created_at', 'updated_at'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function shoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class);
    }
}
