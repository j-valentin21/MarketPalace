<?php

namespace App\Traits;

use App\Http\Resources\UserResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

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
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        $collection = $this->transformCollectionData($collection);
        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200): \Illuminate\Http\JsonResponse
    {
        $instance = $this->transformResourceData($instance);
        return $this->successResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformCollectionData($data)
    {
        $resource = UserResource::collection($data);

        return $resource->toArray($data);
    }

    protected function transformResourceData($data)
    {
        $resource =  new UserResource($data);

        return $resource->toArray($data);
    }
}
