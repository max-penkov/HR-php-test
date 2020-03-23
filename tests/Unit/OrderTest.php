<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Order;
use App\OrderProduct;
use App\Partner;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Class OrderTest
 * @package Tests\Unit
 */
class OrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function order_has_the_partner()
    {
        $order = factory(Order::class)->create();
        $this->assertInstanceOf(Partner::class, $order->partner);
    }

    /**
     * @test
     */
    public function order_has_products()
    {
        $count   = 10;
        $order    = factory(Order::class)->create();
        factory(OrderProduct::class)->times($count)->create(['order_id' => $order->id]);

        $this->assertCount($count, $order->products);
        $this->assertInstanceOf(Collection::class, $order->products);
    }

    /**
     * @test
     */
    public function order_products_belongs_to_product()
    {
        $order    = factory(Order::class)->create();
        $orderProduct = factory(OrderProduct::class)->create(['order_id' => $order->id]);

        $this->assertInstanceOf(Product::class, $orderProduct->product);
    }
}