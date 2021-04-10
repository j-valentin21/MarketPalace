<?php

namespace App\Traits;

use App\Http\Resources\BuyerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SellerResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        $collection = $this->transformCollectionData($collection);
        $collection = $this->cacheResponse($collection);

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

    protected function sortData(Collection $collection)
    {
        if (request()->has('sort_by')) {
            $input = request()->sort_by;
            $attribute = $this->setNewAttributeNames($collection, $input);
            $collection = $collection->sortBy->$attribute->values()->all();
        }
        return $collection;
    }


    protected function paginate($collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }
        $collection = collect($collection);
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());
        return $paginated;
    }

    protected function transformCollectionData($data): array
    {
        $resource = $this->getCollectionName($data);

        return $resource->toArray($data);
    }

    protected function transformResourceData($data): array
    {
        $resource = $this->getResourceName($data);

        return $resource->toArray($data);
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 60, function() use($data) {
            return $data;
        });
    }

    protected function getCollectionName($data)
    {
        $resource = $data[0]->resource;
        $resourceName = Str::of($resource)->substr(19);

        switch ($resourceName) {
            case "BuyerResource":
                return BuyerResource::collection($data);
            case "CategoryResource":
                return CategoryResource::collection($data);
            case "ProductResource":
                return ProductResource::collection($data);
            case "SellerResource":
                return SellerResource::collection($data);
            case "UserResource":
                return UserResource::collection($data);
            case "TransactionResource":
                return TransactionResource::collection($data);
            default:
                $this->errorResponse('The resource your searching for could not be found', 404);
        }
    }

    protected function getResourceName($data)
    {
        $resource = $data->resource;
        $resourceName = Str::of($resource)->substr(19);

        switch ($resourceName) {
            case "BuyerResource":
                return new BuyerResource($data);
            case "CategoryResource":
                return new CategoryResource($data);
            case "ProductResource":
                return new ProductResource($data);
            case "SellerResource":
                return new SellerResource($data);
            case "UserResource":
                return new UserResource($data);
            case "TransactionResource":
                return new TransactionResource($data);
            default:
                $this->errorResponse('The resource your searching for could not be found', 404);
        }
    }

    protected function setNewAttributeNames($data, $input)
    {
        $resource = $data[0]->resource;
        $resourceName = Str::of($resource)->substr(19);

        switch ($resourceName) {
            case "BuyerResource":
                return BuyerResource::originalAttribute($input);
            case "CategoryResource":
                return CategoryResource::originalAttribute($input);
            case "ProductResource":
                return ProductResource::originalAttribute($input);
            case "SellerResource":
                return SellerResource::originalAttribute($input);
            case "UserResource":
                return UserResource::originalAttribute($input);
            case "TransactionResource":
                return TransactionResource::originalAttribute($input);
            default:
                $this->errorResponse('The resource your searching for could not be found', 404);
        }
    }
}
