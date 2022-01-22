<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @param $result
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @param $statusMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404,$statusMessage=null)
    {
        $response = [
            'error' => true,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return ($statusMessage ==null)? response()->json($response):response()->json($response);
    }
}
