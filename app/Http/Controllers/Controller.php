<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function response($message, $status = true, $statusCode = 200){
        return response()->json(
            [
                "status" => $status,
                "result" => $message,
            ], $statusCode
        );
    }
}
