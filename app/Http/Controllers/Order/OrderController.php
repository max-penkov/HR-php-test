<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Http\Controllers\Controller;
use App\UseCases\OrderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Получаем список новых заказов
     *
     * @return LengthAwarePaginator
     */
    public function newest()
    {
        return $this->orderService->newest();
    }

    /**
     * Получаем список просроченных заказов
     *
     * @return mixed
     */
    public function overtaken()
    {
        return $this->orderService->overtaken();
    }
}
