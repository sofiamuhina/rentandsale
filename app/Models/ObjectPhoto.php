<?php

namespace App\Models;

use App\Entities\Model;

class ObjectPhoto extends Model {

    /**
     * @var type 
     */
    protected $fillable = [
        'name', 'path', 'object_id'
    ];

    /*public function products() {
        return $this->hasMany(Product::class, 'retailer_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'retailer_id');
    }*/

}
