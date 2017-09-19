<?php

namespace App;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password'
    ];

//    protected $dates = ['birth_date'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'inventories');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class);
    }

//    public function state()
//    {
//        return $this->belongsTo(State::class);
//    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function getBirthDateAttribute($value)
    {
        if ($value != null) {
            return Carbon::parse($value)->format('Y-m-d');
        }
        return null;
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }

    public function scopeFindUserByEmail($query, $email)
    {
        return $query->where('email', $email)->where('status', 'active')->first();
    }

    public function scopeFindUserByToken($query, $id)
    {
        return $query->findOrFail($id);
    }
}
