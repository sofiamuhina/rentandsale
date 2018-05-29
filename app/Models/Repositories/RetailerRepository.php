<?php

namespace App\Models\Repositories;

use Prettus\Validator\Contracts\ValidatorInterface;
use App\Models\Retailer;

class RetailerRepository extends BaseRepository {

    public function model() {
        return Retailer::class;
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|between:1,40',
            'description' => 'nullable|string|max:40'],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string|between:1,40',
            'description' => 'nullable|string|max:40',]
    ];

}
