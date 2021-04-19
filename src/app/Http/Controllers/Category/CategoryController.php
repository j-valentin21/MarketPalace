<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . CategoryResource::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = Category::all();

        return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->allowedAdminAction();

        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json($request->validator->messages(), 422);
        }

        $newCategory = Category::create($request->all());
        return $this->showOne($newCategory, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Category $category): \Illuminate\Http\JsonResponse
    {
        $this->allowedAdminAction();

        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category): \Illuminate\Http\JsonResponse
    {
        $category->fill($request->all());
        if ($category->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', 422);
        }

        $category->save();
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        $this->allowedAdminAction();

        $category->delete();

        return $this->showOne($category);
    }
}
