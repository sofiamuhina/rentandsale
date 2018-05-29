<?php

namespace App\Models\Repositories;

use Prettus\Validator\Contracts\ValidatorInterface;
use App\Models\Order;

class OrderRepository extends BaseRepository {

    public function model() {
        return Order::class;
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'delivery_price' => 'nullable|numeric',
            'expected_date_before' => 'nullable|integer',
            'expected_date_after' => 'nullable|integer'],
        ValidatorInterface::RULE_UPDATE => [
            'delivery_price' => 'nullable|numeric',
            'expected_date_before' => 'nullable|integer',
            'expected_date_after' => 'nullable|integer']
    ];

    public function update(array $attributes, $id) {
        if (isset($attributes['is_auto_accept']) &&
                $attributes['is_auto_accept'] === 'false') {
            $attributes['is_auto_accept'] = 0;
        }
        parent::update($attributes, $id);
    }

}
