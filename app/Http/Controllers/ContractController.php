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

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $contract = new Contract();
        $contract->name = $request->name;

        if (! $contract->save()) {
            return response()->json($this->responseService->getFormat(
                'Contract creation failed'
            ), 500);
        }

        return response()->json($this->responseService->getFormat(
            'Contract created'
        ), 201);
    }

    public function update(int $id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $contract = Contract::find($id);

        if (! $contract) {
            return response()->json($this->responseService->getFormat(
                'Contract not found'
            ), 404);
        }

        $contract->name = $request->name;

        if (! $contract->save()) {
            return response()->json($this->responseService->getFormat(
                'Contract update failed'
            ), 500);
        }

        return response()->json($this->responseService->getFormat(
            'Contract updated'
        ), 200);
    }
}
