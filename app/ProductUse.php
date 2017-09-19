<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductUse extends Model
{
    protected $table = 'uses';

    protected $hidden = [
        'pivot',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_use', 'use_id', 'product_id')
            ->with('images')
            ->with('stocks');
    }

    public function activeProducts()
    {
        return $this->belongsToMany(Product::class, 'product_use', 'use_id', 'product_id')
            ->where('status', 'activo')
            ->with('images')
            ->with('stocks');
    }
}
