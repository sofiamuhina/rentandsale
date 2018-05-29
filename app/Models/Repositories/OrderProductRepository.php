<?php

namespace App\Models\Repositories;

use App\Models\OrderProduct;

class OrderProductRepository extends BaseRepository {

    public function model() {
        return OrderProduct::class;
    }

}
