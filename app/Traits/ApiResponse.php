<?php

namespace App\Traits;

trait ApiResponse {
    public function sendResponse($code = 200, $message = '', $data = []) {
        return response()->json([
            "code"=> $code,
            "message"=> $message,
            "data"=> $data,
        ],$code);
    }
}