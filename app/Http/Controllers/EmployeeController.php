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
            Employee::with(['contract:id,name', 'certifications:id,name,description'])->get()->makeHidden(['contract_id', 'created_at', 'updated_at'])
        ));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'age' => 'required|integer|min:16|max:100',
            'start_date' => 'required|date',
            'contract_id' => 'required|integer|exists:contracts,id',
            'certification_ids' => 'array',
            'certification_ids.*' => 'integer|exists:certifications,id'
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->age = $request->age;
        $employee->start_date = $request->start_date;
        $employee->contract_id = $request->contract_id;

        $save = $employee->save();

        $employee->certifications()->attach($request->certification_ids);

        if (!$save) {
            return response()->json($this->responseService->getFormat(
                'Employee creation failed'
            ), 500);
        }

        return response()->json($this->responseService->getFormat(
            'Employee created'
        ), 201);
    }

    public function update(int $id, Request $request)
    {
        $request->validate([
            'name' => 'max:100',
            'age' => 'integer|min:16|max:100',
            'start_date' => 'date',
            'contract_id' => 'integer|exists:contracts,id'
        ]);

        $employee = Employee::find($id);

        if (! $employee) {
            return response()->json($this->responseService->getFormat(
                'Employee not found'
            ), 404);
        }

        if ($request->name) {
            $employee->name = $request->name;
        }
        if ($request->age) {
            $employee->age = $request->age;
        }
        if ($request->start_date) {
            $employee->start_date = $request->start_date;
        }
        if ($request->contract_id) {
            $employee->contract_id = $request->contract_id;
        }

        if (! $employee->save()) {
            return response()->json($this->responseService->getFormat(
                'Employee update failed'
            ), 500);
        }

        return response()->json($this->responseService->getFormat(
            'Employee updated'
        ), 200);
    }
}
