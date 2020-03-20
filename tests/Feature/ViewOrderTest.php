<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Order;
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
    public function get_orders_home_page()
    {
        $this->get('/orders')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function can_get_newest_orders()
    {
        factory(Order::class)->times($this->count)->states('newest')->create();

        // Request orders
        $response = $this->getOrders('/orders/newest');

        // Assert
        $this->assertOrdersByResponse($response);
    }

    /**
     * @test
     */
    public function can_get_overtaken_orders()
    {
        factory(Order::class)->times($this->count)->states('overtaken')->create();

        // Request orders
        $response = $this->getOrders('/orders/overtaken');

        // Assert
        $this->assertOrdersByResponse($response);
    }

    /**
     * @test
     */
    public function can_get_current_orders()
    {
        factory(Order::class)->times($this->count)->states('current')->create();

        // Request orders
        $response = $this->getOrders('/orders/current');

        // Assert
        $this->assertOrdersByResponse($response);
    }

    /**
     * @test
     */
    public function can_get_completed_orders()
    {
        factory(Order::class)->times($this->count)->states('completed')->create();

        // Request orders
        $response = $this->getOrders('/orders/completed');

        // Assert
        $this->assertOrdersByResponse($response);
    }

    /**
     * @param string $url
     *
     * @return array
     */
    private function getOrders(string $url): array
    {
        return $this->getJson($url)
            ->assertStatus(Response::HTTP_OK)
            ->json();
    }

    /**
     * @param array $response
     */
    private function assertOrdersByResponse(array $response)
    {
        $this->assertCount($this->count, $response['data']);
        $this->assertEquals($this->count, $response['total']);
    }
}