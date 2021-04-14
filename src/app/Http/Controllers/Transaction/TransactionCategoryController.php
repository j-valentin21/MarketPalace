<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class TransactionCategoryController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function index(Transaction $transaction): JsonResponse
    {
        $categories = $transaction->product()->with('categories')->get();

        return $this->showAll($categories);
    }
}
