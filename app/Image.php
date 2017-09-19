<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

//    public function getFullPathAttribute()
//    {
//        $image = $this->images()->orderBy('id')->first();
//        return ($image) ? $image->full_path : 'default/path.jpg';
//    }

//    public function getFullPathAttribute()
//    {
//        $picture = $this->pictures()->orderBy('priority')->first();
//        return ($picture) ? $picture->url : 'default/path.jpg';
//    }

//    public function getFullPathAttribute($image)
//    {
//        if ($image->product()->count();){
//            return 'http://www.palmarius.com.ve/images/products/2017-06-22-04-15-38.color.jpg';
//        }
//
//        return $image->full_path;
//    }
    
//    public function getFullPathAttribute(){
//        return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $this->attributes['path'];
//    }
}
