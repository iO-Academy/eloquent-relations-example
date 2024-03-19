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

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'age' => 'required|integer|min:16|max:100',
            'start_date' => 'required|date',
            'contract_id' => 'required|integer|exists:contracts,id'
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->age = $request->age;
        $employee->start_date = $request->start_date;
        $employee->contract_id = $request->contract_id;

        if (! $employee->save()) {
            return response()->json($this->responseService->getFormat(
                'Employee creation failed'
            ), 500);
        }

        return response()->json($this->responseService->getFormat(
            'Employee created'
        ), 201);
    }

}
