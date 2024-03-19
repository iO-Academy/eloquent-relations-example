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
            Certification::with('employees:id,name')->get()->makeHidden(['created_at', 'updated_at'])
        ));
    }
}
