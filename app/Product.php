<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $hidden = ['categories', 'uses', 'pivot'];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'inventories');
    }

    public function uses()
    {
        return $this->belongsToMany(ProductUse::class, 'product_use', 'product_id', 'use_id');
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    
}
