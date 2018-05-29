<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model as BaseModel;
use App\Traits\HasValidators;
use Carbon\Carbon;

abstract class Model extends BaseModel {

    use HasValidators;

    //protected $dateFormat = "U";

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);

        $this->dates = array_merge($this->dates, $this->defDates);
        $this->casts = array_merge($this->casts
                , array_fill_keys($this->dates, 'timestamp'));
    }

    private $defDates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $guarded = ['created_at', 'updated_at'];

    public function setAttribute($key, $value) {
        if (!empty($value) && in_array($key, $this->casts) && $this->casts[$key] == 'timestamp') {
            $value = Carbon::createFromTimestamp($value)
                    ->toFormattedDateString();
        }
        parent::setAttribute($key, $value);
    }

}
