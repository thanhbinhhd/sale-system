<?php

namespace App\Model;

use App\Http\Middleware\Authenticate;
use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    //
    use Notifiable;
    const STAFF = 0;
    const ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'level', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();
//
//        static::addGlobalScope(new StatusScope());
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'admin_products', 'admin_id', 'product_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'admin_id');
    }

    public function adminPermission() {
        return $this->hasOne(AdminPermission::class, 'admin_id');
    }

}
