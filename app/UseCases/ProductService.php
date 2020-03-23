<?php

declare(strict_types=1);

namespace App\UseCases;

use App\OrderProduct;
use App\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ProductService
 * @package App\UseCases
 */
class ProductService
{
    const PER_PAGE = 25;

    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return OrderProduct::paginate(self::PER_PAGE);
    }

    /**
     * @param OrderProduct $orderProduct
     * @param array        $data
     *
     * @return OrderProduct
     */
    public function update(OrderProduct $orderProduct, array $data)
    {
        if (isset($data['price'])) {
            $orderProduct->update([
                'price' => $data['price'],
            ]);
        }

        if (isset($data['vendor_id'])) {
            $vendor = Vendor::findOrFail($data['vendor_id']);
            $orderProduct->product()->update(['vendor_id' => $vendor->id]);
        }

        if (isset($data['name'])) {
            $orderProduct->product()->update(['name' => $data['name']]);
        }

        return $orderProduct;
    }
}