<?php



namespace App\Models\Repositories\Criteria;

class In extends AbstractCriteria {
    
    protected $column;
    protected $params;


    public function __construct($column, $params) {
        $this->column = $column;
        $this->params = $params;
    }
    
    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        return $model->whereIn($this->column, $this->params);
    }
}
