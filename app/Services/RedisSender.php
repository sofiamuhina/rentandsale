<?php

namespace App\Services;

use App\Constants\SECategories;
use App\Constants\SETypes;
use App\Models\Services\SystemEventService;
use LRedis;
use App\Models\SEType;

class RedisSender {

    public static function send($typeId, $entityId, $userId
    , $additionalData = null) {
        $categoryId = !empty($additionalData['category_id']) ?
                $additionalData['category_id'] :
                SEType::findOrFail($typeId)->category_id;
        
        $seParams = [
            'category_id' => $categoryId,
            'se_type_id' => $typeId
        ];
        $message = [];

        switch ($categoryId) {
            case SECategories::ORDER:
                $seParams['order_id'] = $entityId;
                $message['channel'] = 'order/' . $entityId;
                break;
            case SECategories::OFFER:
                $seParams['offer_id'] = $entityId;
                $message['channel'] = 'offer/' . $entityId;
                break;
            default:
                return false;
        }

        $systemEvent = app()->make(SystemEventService::class)
                ->create($seParams);

        switch ($typeId) {
            case SETypes::ORDER_COMPLETED:

                break;
            default:
        }

        $message['data'] = [
            'systemEvent' => $systemEvent
        ];

        $result = LRedis::connection()->publish('user/' . $userId
                , json_encode($message));

        if ($result) {
            return $systemEvent;
        }
        return false;
    }

}
