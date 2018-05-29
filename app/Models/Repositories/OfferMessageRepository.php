<?php

namespace App\Models\Repositories;

use App\Models\OfferMessage;

class OfferMessageRepository extends BaseRepository {

    public function model() {
        return OfferMessage::class;
    }

}
