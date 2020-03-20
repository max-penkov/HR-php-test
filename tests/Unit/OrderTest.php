<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Order;
use App\Partner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
}