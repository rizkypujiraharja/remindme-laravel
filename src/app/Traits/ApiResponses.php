<?php

namespace App\Traits;

trait ApiResponses
{
    public function successApiResponse($data = [], $code = 200)
    {
        return response()->json([
            'ok' => true,
            'data' => $data
        ], $code);
    }

    public function errorApiResponse($message = 'Error', $error = 'ERR_INTERNAL_ERROR', $code = 500, $trace = [])
    {
        $response = [
            'ok' => false,
            'err' => $error,
            'msg' => $message
        ];
        if (config('app.debug') && !empty($trace)) {
            $response['trace'] = $trace;
        }
        return response()->json($response, $code);
    }

    public function notFound($message = 'Resource is not found', $error = 'ERR_NOT_FOUND', $code = 404)
    {
        return $this->errorApiResponse($message, $error, $code);
    }
}
