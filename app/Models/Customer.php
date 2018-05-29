<?php

namespace App\Models;

use App\Entities\Model;

class Customer extends Model {

    /**
     * @var type 
     */
    protected $fillable = [
        'name', 'requirements', 'phone', 'status_id', 'user_id', 'owner_id', 'is_sale'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }



}