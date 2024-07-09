<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponse
{
    public function throw($message, $code)
    {
        throw new HttpResponseException(response()->json(["message" => $message], $code));
    }

    public function sendMessage($message, $code)
    {
        return response()->json(["message" => $message], $code);
    }

    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'data' => $result
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }
}
