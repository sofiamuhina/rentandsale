<?php

namespace App\Models\Repositories\Criteria;

class InRadius extends AbstractCriteria {

    protected $radius, $longitude, $latitude, $longCol, $latCol;

    /**
     * If join is required
     *
     * @var array $joinParams [table, first, operator, second, type = 'inner']
     */
    protected $joinParams;

    public function __construct($radius, $longitude, $latitude
    , $longCol, $latCol
    , array $joinParams = null) {
        $this->radius = $radius;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->longCol = $longCol;
        $this->latCol = $latCol;
        $this->joinParams = $joinParams;
    }

    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository) {
        $criteriaList[] = new Join(
                "addresses", 'orders.address_id', '=', 'addresses.id');

        if (!empty($this->joinParams) &&
                is_array($this->joinParams) &&
                count($this->joinParams) >= 4 //&&
                //!empty($this->joinParams['table']) &&
                //!empty($this->joinParams['first']) &&
                //!empty($this->joinParams['operator']) &&
                //!empty($this->joinParams['second'])
                ) {

            $this->joinParams[4] = empty($this->joinParams[4]) ?
                    'inner' : $this->joinParams[4];

           /*$model = $model->join($this->joinParams['table']
                    , $this->joinParams['first']
                    , $this->joinParams['operator']
                    , $this->joinParams['second']
                    , $this->joinParams['type']);*/
            $model->join($this->joinParams[0]
                    , $this->joinParams[1]
                    , $this->joinParams[2]
                    , $this->joinParams[3]
                    , $this->joinParams[4]);
        }

        $latCol = $this->latCol;
        $longCol = $this->longCol;
        $query = "6371 * 2 * ASIN(SQRT(POWER"
                . "(SIN((? - $latCol) "//second ? = latcol
                . "*  pi()/180 / 2), 2) "
                . "+ COS(? * pi()/180) "//? = latitude
                . "* COS($latCol * pi()/180) "//? = latcol
                . "* POWER(SIN((? - $longCol) "//second ?= longcol
                . "* pi()/180 / 2), 2) )) <= ?"; //? = radius

        $params = [
            $this->latitude, //$this->latCol,
            $this->latitude,
            //$this->latCol,
            $this->longitude, //$this->longCol,
            $this->radius
        ];

        return $model->whereRaw($query, $params);
    }

}
