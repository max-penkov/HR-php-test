<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\OrderProduct;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * Class ViewProductsTest
 * @package Tests\Feature
 */
class ViewProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_see_products()
    {
        $count = 10;
        $this->disableExceptionHandling();
        factory(OrderProduct::class)->times($count)->create();

        $response = $this->getJson(route('order.products'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount($count, $response['data']);
        $this->assertEquals($count, $response['total']);
    }
}