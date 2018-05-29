<?php

namespace App\Exceptions;

use Exception;

class GenericException extends Exception {

    protected $data;

    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function setData($data) {
        $this->data = $data;
    }

}
