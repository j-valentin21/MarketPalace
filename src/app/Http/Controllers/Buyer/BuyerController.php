<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $buyers = Buyer::has('transactions')->get();

        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Buyer $buyer): \Illuminate\Http\JsonResponse
    {
        return $this->showOne($buyer);
    }
}
