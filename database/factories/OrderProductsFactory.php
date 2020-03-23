<?php

declare(strict_types=1);

/** @var Factory $factory */

use App\Order;
use App\OrderProduct;
use App\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(OrderProduct::class, function (Faker $faker) {
    $product = factory(Product::class)->create();
    return [
        'order_id'   => function () {
            return factory(Order::class)->create()->id;
        },
        'product_id' => $product->id,
        'quantity'   => rand(1, 3),
        'price'      => $product->price,
    ];
});