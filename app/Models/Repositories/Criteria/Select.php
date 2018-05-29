<?php

namespace App\Models\Repositories\Criteria;

class Select extends AbstractCriteria {
    
    protected $select;


    public function __construct($select) {
        $this->select = $select;
    }
    
    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        return $model->select($this->select);
    }
}
