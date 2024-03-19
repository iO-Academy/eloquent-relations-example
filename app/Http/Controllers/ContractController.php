<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Services\JsonResponseService;
use Illuminate\Http\Request;

class ContractController extends Controller
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
            Contract::with('employees:id,name,contract_id')->get()
        ));
    }
}
