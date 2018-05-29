<?php

namespace App\Models\Repositories\Criteria\OrderReviews;

use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Repositories\Criteria\AbstractCriteria;

class JoinOrdersOnOrderId extends AbstractCriteria {

    protected $userId;

    public function __construct($userId) {
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository) {
        return $model->join('orders', 'orders.id', '=', 'order_reviews.order_id')
        ->where('order_reviews.user_id', '!=', $this->userId)
                ->select(['order_reviews.*']);
    }

}
