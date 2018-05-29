<?php

namespace App\Models\Repositories;

use App\Models\Product;
use App\Models\Validators\ProductValidator;

class ProductRepository extends BaseRepository {

    public function model() {
        return Product::class;
    }

    public function validator() {
        return ProductValidator::class;
    }

}
