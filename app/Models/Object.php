<?php

namespace App\Models;

use App\Entities\Model;

class Object extends Model {

    /**
     * @var type 
     */
    protected $fillable = [
        'price', 'description', 'yardage', 'address', 'status_id', 'district_id', 'owner_id', 'is_sale'
    ];

    /*public function products() {
        return $this->hasMany(Product::class, 'retailer_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'retailer_id');
    }*/

}
