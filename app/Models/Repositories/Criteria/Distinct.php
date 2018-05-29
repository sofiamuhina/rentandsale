<?php

namespace App\Models\Repositories\Criteria;

class Distinct extends AbstractCriteria {

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        return $model->distinct();
    }

}
