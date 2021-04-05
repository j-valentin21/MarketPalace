<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreProductBuyerTransactionRequest;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;

class ProductBuyerTransactionController extends ApiController
{
    private ProductService $productService;

    public function __construct(ProductService $service)
    {
        $this->productService = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductBuyerTransactionRequest $request
     * @param Product $product
     * @param User $buyer
     *
     */
    public function store(StoreProductBuyerTransactionRequest $request, Product $product, User $buyer)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json($request->validator->messages(), 422);
        }
        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('The buyer must be different from the seller', 409);
        }
        if (!$buyer->isVerified()) {
            return $this->errorResponse('The buyer must be a verified user', 409);
        }
        if (!$product->seller->isVerified()) {
            return $this->errorResponse('The seller must be a verified user', 409);
        }
        if (!$product->isAvailable()) {
            return $this->errorResponse('The product is not available', 409);
        }
        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('The product does not have enough units for this transaction', 409);
        }

       return $this->productService->createTransaction($request,$product,$buyer);
    }
}
