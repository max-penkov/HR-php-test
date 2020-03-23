<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\OrderProduct;
use App\UseCases\ProductService;
use App\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param Request $request
     *
     * @return LengthAwarePaginator|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->productService->all();
        }

        $vendors = Vendor::all()->pluck('name', 'id');
        return view('orders.products', compact('vendors'));
    }

    /**
     * @param OrderProduct $orderProduct
     *
     * @return OrderProduct
     */
    public function update(OrderProduct $orderProduct)
    {
        $data = request()->validate([
            'price'     => 'integer',
            'vendor_id' => 'exists:vendors,id',
            'name'      => 'nullable|string|max:255',
        ]);

        return $this->productService->update($orderProduct, $data);
    }
}
