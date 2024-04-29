<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Contracts\Validation\Validator;

class MyValidationException extends Exception {
    use ApiResponse;
    protected $validator;

    protected $code = 422;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function render() {

        return $this->sendResponse(
            $this->code,
            array_values($this->validator->errors()->getMessages())[0][0],
            $this->validator->errors()
        );
    }
}