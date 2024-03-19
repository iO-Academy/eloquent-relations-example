<?php

namespace App\Services;

class JsonResponseService
{
    public function getFormat(string $message, mixed $data = false): array
    {
        $result = [
            'message' => $message,
        ];

        if ($data) {
            $result['data'] = $data;
        }

        return $result;
    }
}
