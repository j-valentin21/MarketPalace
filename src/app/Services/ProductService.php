<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Create transaction with product and buyer data.
     *
     * @param $request
     * @param $product
     * @param $buyer
     * @return mixed
     */
    public function createTransaction($request, $product, $buyer)
    {
        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return response()->json($transaction, 201);
        });
    }
}
