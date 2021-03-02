<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $seller = Seller::has('products')->get();

        return response()->json(['data' => $seller]);
    }

    /**
     * Display the specified resource.
     *
     * @param Seller $seller
     * @return Seller
     */
    public function show(Seller $seller)
    {
        return $seller;
    }

}
