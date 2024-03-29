<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;

class SellerBuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Seller $seller
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Seller $seller): JsonResponse
    {
        $this->allowedAdminAction();

        $buyers = $seller->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();

        return $this->showAll($buyers);
    }
}
