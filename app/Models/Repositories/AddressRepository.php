<?php

namespace App\Models\Repositories;

use App\Models\Address;
use Prettus\Validator\Contracts\ValidatorInterface;

class AddressRepository extends BaseRepository {

    public function model() {
        return Address::class;
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'address' => 'required|string|unique_with:addresses,latitude,longitude',
            'user_id' => 'required|numeric',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'comment' => 'nullable|string',
            'city' => 'required|string'],
        ValidatorInterface::RULE_UPDATE => [
            'address' => 'required|string|unique_with:addresses,latitude,longitude',
            'user_id' => 'required|numeric',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'comment' => 'nullable|string',
            'city' => 'sometimes|required|string']
    ];
}
