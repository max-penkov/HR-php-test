<?php

declare(strict_types=1);

/** @var Factory $factory */

use App\Vendor;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Vendor::class, function (Faker $faker) {
    $createdAt = Carbon::now()->subDays(rand(0, 4));
    return [
        'name'       => $faker->company,
        'email'      => $faker->companyEmail,
        'created_at' => $createdAt,
        'updated_at' => $createdAt->copy()->addHours(rand(1, 5)),
    ];
});