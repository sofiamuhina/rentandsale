<?php

namespace App\Models\Repositories\Criteria;

class Where extends AbstractCriteria {

    protected $params;

    /**
     * Only arrays are accepted
     * 
     * @param array $params
     */
    public function __construct(array $params) {
        $this->params = $params;
    }

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        foreach ($this->params as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $model->where($field, $condition, $val);
            } else {
                $model->where($field, '=', $value);
            }
        }
        return $model;
    }

}
