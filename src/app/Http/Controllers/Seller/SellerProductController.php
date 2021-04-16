<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreSellerProductRequest;
use App\Http\Requests\UpdateSellerProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Services\SellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends ApiController
{
    private sellerService $sellerService;

    public function __construct(SellerService $service)
    {
        $this->sellerService = $service;
        parent::__construct();
        $this->middleware('transform.input:' . ProductResource::class)->only(['update', 'store']);
        $this->middleware('scope:manage-products');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function index(Seller $seller): JsonResponse
    {
        $products = $seller->products;

        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSellerProductRequest $request
     * @param User $seller
     * @return JsonResponse
     */
    public function store(StoreSellerProductRequest $request, User $seller): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json($request->validator->messages(), 422);
        }

        $data = $request->validated();

        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSellerProductRequest $request
     * @param Seller $seller
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateSellerProductRequest $request, Seller $seller, Product $product): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json($request->validator->messages(), 422);
        }

        $this->sellerService->checkSeller($seller,$product);
        $product->fill($request->validated());

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return $this->errorResponse('An active product must have at least one category', 409);
            }
        }

        if ($request->hasFile('image')) {
            Storage::delete($product->image);

            $product->image = $request->image->store('');
        }

        if ($product->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Seller $seller
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Seller $seller, Product $product): JsonResponse
    {
        $this->sellerService->checkSeller($seller,$product);
        Storage::delete($product->image);
        $product->delete();
        return $this->showOne($product);
    }
}
