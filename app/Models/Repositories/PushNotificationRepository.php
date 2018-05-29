<?php

namespace App\Models\Repositories;

use App\Models\PushNotification;

class PushNotificationRepository extends BaseRepository {

    public function model() {
        return PushNotification::class;
    }

}
