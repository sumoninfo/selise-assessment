<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * return response api
     */
    protected function returnResponse($status = "success", $message = "Successfully", $data = null, $status_code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data], $status_code);
    }
}
