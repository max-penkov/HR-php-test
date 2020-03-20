<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Сервис для работы с заказами
 *
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

    /**
     * @return LengthAwarePaginator
     */
    public function overtaken()
    {
        return Order::with('partner')
            ->where([
                'status' => Order::STATUS_CONFIRMED,
                ['delivery_dt', '<', now()],
            ])->paginate(self::PER_PAGE);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function current()
    {
        return Order::with('partner')
            ->where('status', Order::STATUS_CONFIRMED)
            ->WhereDay('delivery_dt', '>', 1)
            ->paginate(self::PER_PAGE);
    }
}