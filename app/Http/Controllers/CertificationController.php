<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Services\JsonResponseService;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    private JsonResponseService $responseService;

    public function __construct(JsonResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function all()
    {
        return response()->json($this->responseService->getFormat(
            'Certifications retrieved',
            Certification::all()->makeHidden(['created_at', 'updated_at'])
        ));
    }

    public function find(int $id)
    {
        return response()->json($this->responseService->getFormat(
            'Certification retrieved',
            Certification::with('employees:id,name')->find($id)->makeHidden(['created_at', 'updated_at'])
        ));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $certification = new Certification();
        $certification->name = $request->name;
        $certification->description = $request->description;

        if (! $certification->save()) {
            return response()->json($this->responseService->getFormat(
                'Certification creation failed'
            ), 500);
        }

        return response()->json($this->responseService->getFormat(
            'Certification created'
        ), 201);
    }
}
