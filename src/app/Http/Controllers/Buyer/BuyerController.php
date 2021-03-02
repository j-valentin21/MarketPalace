<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();

        return response()->json(['data' => $buyers]);
    }

    /**
     * Display the specified resource.
     *
     * @param Buyer $buyer
     * @return Buyer
     */
    public function show(Buyer $buyer)
    {
        return $buyer;
    }

}
