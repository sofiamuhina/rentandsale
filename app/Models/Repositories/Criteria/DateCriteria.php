<?php

namespace App\Models\Repositories\Criteria;

use Carbon\Carbon;

class DateCriteria extends AbstractCriteria {

    protected $params;

    public function __construct($fieldName, $operator, $unixTimestamp) {
        $this->params['name'] = $fieldName;
        $this->params['operator'] = $operator;
        $this->params['time'] = $unixTimestamp;
    }

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        return $model->where($this->params['name'], $this->params['operator']
                        , Carbon::createFromTimestamp($this->params['time'])
                                ->toDateTimeString());
    }

}
