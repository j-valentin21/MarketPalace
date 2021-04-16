<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Buyer $buyer
     * @return JsonResponse
     */
    public function index(Buyer $buyer): JsonResponse
    {
        $products = $buyer->transactions()->with('product')
            ->get()
            ->pluck('product');

        return $this->showAll($products);
    }

}
