<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductBuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Product $product
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Product $product): JsonResponse
    {
        $this->allowedAdminAction();

        $buyers = $product->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique()
            ->values();

        return $this->showAll($buyers);
    }
}
