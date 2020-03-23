<?php

declare(strict_types=1);

/** @var Factory $factory */

use App\Product;
use App\Vendor;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    $createdAt = Carbon::now()->subDays(rand(0, 4));
    return [
        'name' => 'Product_' . $faker->name,
        'price' => $faker->numberBetween(100, 1000),
        'vendor_id' => function(){
            return factory(Vendor::class)->create()->id;
        },
        'created_at'   => $createdAt,
        'updated_at'   => $createdAt->copy()->addHours(rand(1, 5)),
    ];
});