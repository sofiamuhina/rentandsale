<?php

namespace App\Models\Repositories;

use App\Models\Store;

class StoreRepository extends BaseRepository {

    public function model() {
        return Store::class;
    }

}
