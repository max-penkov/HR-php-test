<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\OrderCompleted;
use App\Order;
use App\OrderProduct;
use App\Partner;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Class ViewOrderTest
 * @package Tests\Feature
 */
class ViewOrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @@test
     */
    public function view_order()
    {
        $this->disableExceptionHandling();
        $order = factory(Order::class)->create();

        $this->get("/orders/{$order->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewHas('order', function (Order $viewOrder) use ($order) {
                return $order->id === $viewOrder->first()->id && count($order->products) === count($viewOrder->products);
            });
    }

    /**
     * @test
     */
    public function order_can_be_updated()
    {
        $order = factory(Order::class)->create([
            'status' => Order::STATUS_NEW,
        ]);

        $this->patch("/orders/{$order->id}", [
            'client_email' => $email = 'new@mail.ru',
            'status'       => Order::STATUS_CONFIRMED,
            'partner_id'   => $partnerId = factory(Partner::class)->create()->id,
        ])->assertStatus(Response::HTTP_OK);

        tap($order->fresh(), function (Order $order) use ($email, $partnerId) {
            $this->assertEquals($email, $order->client_email);
            $this->assertTrue($order->isConfirmed());
            $this->assertEquals($partnerId, $order->partner_id);
        });
    }

    /**
     * @test
     */
    public function send_email_if_status_changed_to_completed()
    {
        Mail::fake();
        $order = factory(Order::class)->states('newest')->create();
        factory(OrderProduct::class)->times(10)->create(['order_id' => $order->id]);
        $order->status = Order::STATUS_COMPLETED;
        $this->patch("/orders/{$order->id}", $order->toArray());

        Mail::assertQueued(OrderCompleted::class);
    }
}