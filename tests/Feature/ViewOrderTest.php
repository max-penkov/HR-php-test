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
     * @var int
     */
    private $count;

    protected function setUp()
    {
        parent::setUp();
        $this->count = 10;
    }


    /**
     * @test
     */
    public function can_get_newest_orders()
    {
        factory(Order::class)->times($this->count)->states('newest')->create();

        $response = $this->getJson('/orders/newest')
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount($this->count, $response['data']);
        $this->assertEquals($this->count, $response['total']);
    }

    /**
     * @test
     */
    public function can_get_overtaken_orders()
    {
        factory(Order::class)->times($this->count)->states('overtaken')->create();

        $response = $this->getJson('/orders/overtaken')
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount($this->count, $response['data']);
        $this->assertEquals($this->count, $response['total']);
    }

    /**
     * @test
     */
    public function can_get_current_orders()
    {
        factory(Order::class)->times($this->count)->states('current')->create();

        $response = $this->getJson('/orders/current')
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount($this->count, $response['data']);
        $this->assertEquals($this->count, $response['total']);
    }
}