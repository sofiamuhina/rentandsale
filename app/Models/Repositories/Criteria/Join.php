<?php

namespace App\Models\Repositories\Criteria;

class Join extends AbstractCriteria {

    protected $table;
    protected $first;
    protected $operator;
    protected $second;
    protected $type;

    public function __construct($table, $first, $operator, $second
    , $type = "inner") {
        $this->table = $table;
        $this->first = $first;
        $this->operator = $operator;
        $this->second = $second;
        $this->type = $type;
    }

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        return $model->join($this->table, $this->first, $this->operator
                        , $this->second, $this->type);
    }

}
