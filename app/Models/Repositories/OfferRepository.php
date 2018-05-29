<?php

namespace App\Models\Repositories;

use Prettus\Validator\Contracts\ValidatorInterface;
use App\Models\Offer;

class OfferRepository extends BaseRepository {

    public function __construct(\Illuminate\Container\Container $app) {
        parent::__construct($app);
    }

    public function model() {
        return Offer::class;
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'message' => 'nullable|string|max:255',
            'purchase_started' => 'nullable:integer',
            'purchase_completed' => 'nullable:integer'],
        ValidatorInterface::RULE_UPDATE => [
            'message' => 'nullable|string|max:255',
            'purchase_started' => 'nullable:integer',
            'purchase_completed' => 'nullable:integer']
    ];

    public function create(array $attributes) {
        

        //unset($data['order_id']);
        
        //$order->offers()->create($data);


        return parent::create($attributes);
    }
    
    public function update(array $attributes, $id) {
        unset($attributes['user_id']);
        unset($attributes['order_id']);
        parent::update($attributes, $id);
    }

}
