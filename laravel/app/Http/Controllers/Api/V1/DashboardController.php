<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function changeStatus(Request $request)
    {
        $serviceInstance = getServiceInstance($request->modelName);

        $response = $serviceInstance->updateStatus();
        return handleResponse($response);
    }

    public function changeStatusMultiple(Request $request)
    {
        $serviceInstance = getServiceInstance($request->modelName);

        $response = $serviceInstance->updateStatusMultiple();
        return handleResponse($response);
    }

    public function deleteMultiple(Request $request)
    {
        $serviceInstance = getServiceInstance($request->modelName);

        $response = $serviceInstance->deleteMultiple();
        return handleResponse($response);
    }
}
