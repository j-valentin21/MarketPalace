<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerService
{
    /**
     * Check if product belongs to seller before allowing update.
     *
     * @param $seller
     * @param $product
     */
    public function checkSeller($seller, $product)
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422, 'The specified seller is not the actual seller of the product');
        }
    }
}
