<?php

namespace App\Models\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class ProductValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|between:1,40',
            'description' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'image' => 'nullable|mimes:jpeg,jpg,png,bmp,gif,svg|max:3000',
            'unit_id' => 'required|numeric|between:1,2',
            'retailer_id' => 'required|integer|min:0'],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'sometimes|string|between:1,40',
            'description' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'image' => 'nullable|mimes:jpeg,jpg,png,bmp,gif,svg|max:3000',
            'unit_id' => 'sometimes|numeric|between:1,2',
            'retailer_id' => 'sometimes|integer|min:0']
    ];

}
