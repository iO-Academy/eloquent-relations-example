<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\JsonResponseService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private JsonResponseService $responseService;

    public function __construct(JsonResponseService $responseService)
    {
        $this->responseService = $responseService;
    }


    public function all()
    {
        return response()->json($this->responseService->getFormat(
            'Employees retrieved',
            Employee::with('contract:id,name')->get()->makeHidden(['contract_id', 'created_at', 'updated_at'])
        ));
    }

}
