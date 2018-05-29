<?php

namespace App\Models\Repositories\Criteria;

class WhereRaw extends AbstractCriteria {

    protected $query;
    protected $params;

    public function __construct($query, $params = null) {
        $this->query = $query;
        $this->params = $params;
    }

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        return $model->whereRaw($this->query, $this->params);
    }

}
