<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $hidden = [
        'pivot',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->with('images')
            ->with('stocks');
    }

    public function activeProducts()
    {
        return $this->belongsToMany(Product::class)
            ->where('status', 'activo')
            ->with('images')
            ->with('stocks');
    }
}
