<?php

namespace App\Models\Repositories\Criteria\Orders;

use App\Models\Repositories\Criteria\AbstractCriteria;

class HasNoOffersFromUser extends AbstractCriteria {

    protected $userId;

    public function __construct($userId) {
        $this->userId = $userId;
    }

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        /* return $model->join('offers', 'offers.order_id', '=', 'orders.id', 'left')
          //->where('offers.user_id', '!=', $this->userId)
          ; */
        return $model->whereNotIn('orders.id', function($query) {
                    $query->select('offers.order_id')
                            ->from('offers')
                            ->where('offers.user_id', '=', $this->userId);
                });
    }

}
