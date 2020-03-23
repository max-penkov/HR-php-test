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
        return Order::where([
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
        return Order::where([
            'status' => Order::STATUS_CONFIRMED,
            ['delivery_dt', '<', now()],
        ])->orderBy('delivery_dt', 'desc')->paginate(self::PER_PAGE);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function current()
    {
        return Order::where('status', Order::STATUS_CONFIRMED)
            ->WhereDay('delivery_dt', '=', now()->addDay()->format('d'))
            ->orderBy('delivery_dt')
            ->paginate(self::PER_PAGE);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function completed()
    {
        return Order::where('status', Order::STATUS_COMPLETED)
            ->whereDate('delivery_dt', now()->format('Y-m-d'))
            ->orderBy('delivery_dt', 'desc')
            ->paginate(self::PER_PAGE);

    }

    /**
     * @param Order $order
     * @param array $data
     *
     * @return Order
     */
    public function update(Order $order, array $data): Order
    {
        if (isset($data['products']) && !is_null($data['products'])) {
            $products = collect($data['products'])->keyBy('id');
            foreach ($order->products()->get() as $product) {
                /** OrderProduct @var $product */
                $orderProduct = $products->get($product->id);
                $product->update([
                    'quantity' => $orderProduct['quantity'],
                    'price'    => $orderProduct['price'],
                ]);
            }
            unset($data['products']);
        }
        $order->update($data);
        $order->refresh();

        return $order;
    }
}