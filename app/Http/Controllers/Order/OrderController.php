<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Http\Controllers\Controller;
use App\Partner;
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

    /**
     * @param Order $order
     *
     * @return Factory|View
     */
    public function view(Order $order)
    {
        $partners = Partner::all()->pluck('name', 'id');
        return view('orders.show', compact('order', 'partners'));
    }

    /**
     * @param Order $order
     *
     * @return Order
     */
    public function update(Order $order)
    {
        $data = request()->validate([
            'client_email' => 'required|email',
            'status'       => 'required|in:0,10,20',
            'partner_id'   => 'required|exists:partners,id',
            'products'     => 'nullable|array',
        ]);

        $order = $this->orderService->update($order, $data);

        return $order;
    }

}
