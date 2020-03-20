<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class OrderService
 * @package App\UseCases
 */
class OrderService
{
    const PER_PAGE = 25;

    /**
     * @return LengthAwarePaginator
     */
    public function newest()
    {
        return Order::with('partner')
            ->where([
                'status' => Order::STATUS_NEW,
                ['delivery_at', '>', now()],
            ])
            ->orderBy('delivery_dt')
            ->paginate(self::PER_PAGE);
    }
}