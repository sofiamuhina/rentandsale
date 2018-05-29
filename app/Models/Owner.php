<?php

namespace App\Models;

use App\Entities\Model;

class Owner extends Model {

    /**
     * @var type 
     */
    protected $fillable = [
        'name', 'phone', 'is_developer'
    ];

    /*public function products() {
        return $this->hasMany(Product::class, 'retailer_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'retailer_id');
    }*/

}

