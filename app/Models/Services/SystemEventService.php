<?php

namespace App\Models\Services;

use App\Constants\SECategories;
use App\Models\OrderSE;
use App\Models\OfferSE;

class SystemEventService extends BaseService {

    public function create($attributes) {

        $systemEvent = null;
        $seClass = null;
        

        switch ($attributes['category_id']) {
            case SECategories::ORDER:
                $seClass = OrderSE::class;
                break;

            case SECategories::OFFER:
                $seClass = OfferSE::class;
                break;
            default:
                return false;
        }
        
        $attributes['user_id'] = $this->user->id;
        
        $model = app()->make($seClass);
        $systemEvent = $model->newInstance($attributes);
        $systemEvent->save();
        
        return $systemEvent;          
    }

}
