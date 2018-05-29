<?php

namespace App\Models\Repositories\Criteria\Orders;

use App\Models\Repositories\Criteria\AbstractCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

class HasProducts extends AbstractCriteria {

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        return $model->join('order_products', 'orders.id', '=', 'order_products.order_id');
    }

}
