<?php

namespace App\Traits;

use App\Models\Repositories\Criteria\Select;
use App\Models\Repositories\Criteria\Distinct;
use App\Models\Repositories\Criteria\Where;
use App\Models\Repositories\Criteria\DateCriteria;
use App\Models\Repositories\Criteria\In;
use Illuminate\Pagination\Paginator;

/**
 * Class which is using this trait 
 * has to have $request and $repository variables
 * 
 */
trait GetList {

    /**
     * TODO: refactor
     * 
     * @param type $params Can have values: select(array), criteria(array), 
     * where(array), page[size,number]
     */
    public function getList($params = null) {
        $reqParams = $this->request->all();
        $this->unsetThings($reqParams);

        $model = $this->repository->first();
        $tableDot = $model->getTable() . '.';
        $dateAttributes = $model->getDates();

        $criteriaList = $this->makeCriteriaList($params);
        $criteriaList[] = $this->makeSelectCriteria($params, $tableDot);
        $this->addSearchCriteria($reqParams, $criteriaList, $tableDot);
        $sort = $this->makeSort($reqParams);
        $page = $this->makePage($reqParams);

        /* if (isset($params['where'])) {
          $reqParams = array_merge($reqParams, $params['where']);
          } */

        $with = isset($params['with']) ? $params['with'] : [];
        if (isset($reqParams['with']) && is_array($reqParams['with'])) {
            $with = array_merge($with, $reqParams['with']);
        }
        unset($reqParams['with']);

        //removong unset attributes from the request before making Where
        //important for some reason, probably better to leave it here
        $this->request->replace($reqParams);
        $this->addWhereCriteria(
                $criteriaList, $reqParams, $tableDot, $dateAttributes);

        $criteriaList[] = Distinct::class;

        foreach ($criteriaList as $criterion) {
            $this->repository->pushCriteria($criterion);
        }

        $this->setCurrentPage($page);

        return $this->makeResultArray($this->executeQuery($with, $sort, $page));
    }

    /**
     * Temporary method
     */
    private function unsetThings(&$reqParams) {
        unset($reqParams['longitude']);
        unset($reqParams['latitude']);
        unset($reqParams['radius']);
        unset($reqParams['has_products']);
    }

    private function executeQuery($with, $sort, $page) {
        return $this->repository->with($with)
                        ->orderBy($sort['column'], $sort['order'])
                        ->paginate($page['size']);
    }

    private function makeResultArray($result) {
        return ['page' => [
                'size' => $result->perPage(),
                'object_count' => $result->count(),
                'number_current' => $result->currentPage(),
                'number_max' => $result->lastPage(),
                'objects' => $result->getCollection()
        ]];
    }

    private function setCurrentPage($page) {
        Paginator::currentPageResolver(function() use ($page) {
            if (!empty($page['number'])) {
                return $page['number'];
            }
            return 1;
        });
    }

    private function makeCriteriaList($params) {
        if (isset($params['criteria']) && is_array($params['criteria'])) {
            return $params['criteria'];
        }
        return [];
    }

    private function addSearchCriteria(&$reqParams, &$criteriaList, $tableDot) {
        if (isset($reqParams['search']) &&
                isset($reqParams['search']['column']) &&
                isset($reqParams['search']['sequence'])) {
            $criteriaList[] = new Where([[
            $tableDot . $reqParams['search']['column']
            , 'like'
            , '%' . $reqParams['search']['sequence'] . '%']]);
        }
        unset($reqParams['search']);
    }

    private function makeSort(&$reqParams) {
        $sort = ['column' => 'id', 'order' => 'desc'];
        if (isset($reqParams['sort']['column']) &&
                isset($reqParams['sort']['order'])) {
            $sort = ['column' => $reqParams['sort']['column'],
                'order' => $reqParams['sort']['order']];
        }
        unset($reqParams['sort']);
        return $sort;
    }

    private function makeSelectCriteria($params, $tableDot) {
        $select = isset($params['select']) && is_array($params['select']) ?
                $params['select'] : $tableDot . '*';
        return new Select($select);
    }

    private function makePage(&$reqParams) {
        $page = ['size' => 100];
        if (!empty($reqParams['page']['size'])) {
            $page['size'] = $reqParams['page']['size'];
            if (!empty($reqParams['page']['number'])) {
                $page['number'] = $reqParams['page']['number'];
            }
        }
        unset($reqParams['page']);
        return $page;
    }

    /**
     * Refactor
     * 
     * @param type $criteriaList
     * @param type $reqParams
     * @param type $tableDot
     * @param type $dateAttributes
     */
    private function addWhereCriteria(&$criteriaList, &$reqParams, $tableDot
    , $dateAttributes) {
        $newParams = [];
        foreach ($reqParams as $key => $param) {
            unset($reqParams[$key]);
            if (is_array($param)) {
                if (isset($param['value']) && isset($param['operator'])) {
                    if (in_array($key, $dateAttributes)) {
                        //date
                        $criteriaList[] = new DateCriteria($tableDot . $key
                                , $param['operator'], $param['value']);
                    } else {
                        //param with custom operator
                        $newParams[] = [$tableDot . $key, $param['operator']
                            , $param['value']];
                    }
                } else {
                    if (!isset($param['value']) &&
                            !isset($param['operator']) &&
                            is_string($key)) {
                        //in params
                        $criteriaList[] = new In(
                                $tableDot . $key, $param);
                    }
                }
            } else {
                if (is_string($key)) {
                    //usual param
                    $newParams[$tableDot . $key] = $param;
                }
            }
        }

        $criteriaList[] = new Where(array_merge($reqParams, $newParams));
    }

}
