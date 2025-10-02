<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @param     $data
     * @param int $status_code
     *
     * @return JsonResponse
     */
    public function success($data, int $status_code): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ], $status_code);
    }


    /**
     * @param string $message
     * @param int    $status_code
     * @param string $status
     *
     * @return JsonResponse
     */
    public function fail(string $message, int $status_code = 400, string $status = 'fail'): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
        ], $status_code);
    }
   
}
