<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\OrderProduct;
use App\Product;
use App\Vendor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * Class ProductTest
 * @package Tests\Unit
 */
class ProductTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function product_has_vendor()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Vendor::class, $product->vendor);
    }

    /**
     * @test
     */
    public function order_can_be_updated()
    {
        $this->disableExceptionHandling();
        $orderProduct = factory(OrderProduct::class)->create();
        $vendor       = factory(Vendor::class)->create();

        $this->patch("/orders/products/{$orderProduct->id}", [
            'price'     => $price = 4000,
            'vendor_id' => $vendor->id,
            'name'      => $name = 'name',
        ])->assertStatus(Response::HTTP_OK);

        tap($orderProduct->fresh(), function (OrderProduct $orderProduct) use ($price, $vendor, $name) {
            $this->assertEquals($price, $orderProduct->price);
            $this->assertEquals($vendor->id, $orderProduct->product->vendor->id);
            $this->assertEquals($name, $orderProduct->product->name);
        });
    }

}