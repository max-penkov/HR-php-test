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
class ViewOrdersTest extends TestCase
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
        $this->createAllOrders();

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
        $this->createAllOrders();

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
        $this->createAllOrders();

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
        $this->createAllOrders();

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

    private function createAllOrders()
    {
        factory(Order::class)->times($this->count)->states('newest')->create();
        factory(Order::class)->times($this->count)->states('overtaken')->create();
        factory(Order::class)->times($this->count)->states('current')->create();
        factory(Order::class)->times($this->count)->states('completed')->create();
    }
}