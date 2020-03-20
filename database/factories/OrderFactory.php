<?php

declare(strict_types=1);

/** @var Factory $factory */

use App\Order;
use App\Partner;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(App\Order::class, function (Faker $faker) {
    $status    = [0, 10, 20];
    $createdAt = Carbon::now()->subDays(rand(0, 4));
    return [
        'status'       => $status[rand(0, 2)],
        'client_email' => $faker->email,
        'partner_id'   => function () {
            return factory(Partner::class)->create()->id;
        },
        'delivery_dt'  => $createdAt->copy()->addHours(rand(6, 50)),
        'created_at'   => $createdAt,
        'updated_at'   => $createdAt->copy()->addHours(rand(1, 5)),
    ];
});

$factory->state(Order::class, 'newest', function () {
    return [
        'status'      => Order::STATUS_NEW,
        'delivery_dt' => now()->addDay(),
    ];
});

$factory->state(Order::class, 'overtaken', function () {
    return [
        'status'      => Order::STATUS_CONFIRMED,
        'delivery_dt' => now()->subDay(),
    ];
});

$factory->state(Order::class, 'current', function () {
    return [
        'status'      => Order::STATUS_CONFIRMED,
        'delivery_dt' => now()->addDay(),
    ];
});

$factory->state(Order::class, 'completed', function () {
    return [
        'status'      => Order::STATUS_COMPLETED,
        'delivery_dt' => now(),
    ];
});
