<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Http\Controllers\Controller;
use App\UseCases\OrderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class OrderController
 * @package App\Http\Controllers\Order
 */
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
     * Листинг всех ордеров
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Получаем список новых заказов
     *
     * @param Request $request
     *
     * @return LengthAwarePaginatorAlias|Factory|View
     */
    public function newest(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->orderService->newest();
        }

        return view('orders.newest');
    }

    /**
     * Получаем список просроченных заказов
     *
     * @param Request $request
     *
     * @return LengthAwarePaginatorAlias|Factory|View
     */
    public function overtaken(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->orderService->overtaken();
        }

        return view('orders.overtaken');
    }

    /**
     * Получаем список текущих заказов
     *
     * @param Request $request
     *
     * @return LengthAwarePaginatorAlias|Factory|View
     */
    public function current(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->orderService->current();
        }

        return view('orders.current');
    }

    /**
     * Получаем список выполненных заказов
     *
     * @param Request $request
     *
     * @return LengthAwarePaginatorAlias|Factory|View
     */
    public function completed(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->orderService->completed();
        }

        return view('orders.completed');
    }
}
