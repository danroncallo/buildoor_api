<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
