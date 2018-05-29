<?php

namespace App\Models\Repositories;

use App\Models\OrderReview;
use Prettus\Validator\Contracts\ValidatorInterface;

class OrderReviewRepository extends BaseRepository {

    public function model() {
        return OrderReview::class;
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'message' => 'required|string',
            'rate' => 'nullable|integer|between:1,5'],
        ValidatorInterface::RULE_UPDATE => [
            'message' => 'sometimes|required|string',
            'rate' => 'nullable|integer|between:1,5']
    ];

}
