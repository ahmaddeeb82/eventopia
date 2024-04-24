<?php

namespace App\Trairs;

trait ApiResponse {
    public function sendResponse($code = 200, $message = '', $data = []) {
        return response()->json([
            "code"=> $code,
            "message"=> $message,
            "data"=> $data,
        ],$code);
    }
}