<?php

namespace App\Models;

use App\Entities\Model;

class Bargain extends Model {

    /**
     * @var type 
     */
    protected $fillable = [
        'price', 'status_id', 'object_id', 'customer_id'
    ];

    /*public function products() {
        return $this->hasMany(Product::class, 'retailer_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'retailer_id');
    }*/

}
