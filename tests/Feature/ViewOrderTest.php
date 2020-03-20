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
        $this->disableExceptionHandling();
        factory(Order::class)->times(10)->create([
            'status' => Order::STATUS_NEW,
            'delivery_dt' => now()->addDay(10)
        ]);

        $response = $this->getJson('/orders/newest')
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount(10, $response['data']);
        $this->assertEquals(10, $response['total']);
    }
}