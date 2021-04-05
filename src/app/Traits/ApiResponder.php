<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponder
{
    private function successResponse($data, $code): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse($instance, $code);
    }
}
