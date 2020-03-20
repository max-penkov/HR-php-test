<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * Class ViewOrderTest
 * @package Tests\Feature
 */
class ViewOrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_get_newest_orders()
    {
        $count = 10;
        factory(Order::class)->times($count)->states('newest')->create();

        $response = $this->getJson('/orders/newest')
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount($count, $response['data']);
        $this->assertEquals($count, $response['total']);
    }

    /**
     * @test
     */
    public function can_get_overtaken_orders()
    {
        $this->disableExceptionHandling();
        $count      = 10;

        factory(Order::class)->times($count)->states('overtaken')->create();

        $response = $this->getJson('/orders/overtaken')
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount($count, $response['data']);
        $this->assertEquals($count, $response['total']);
    }
}