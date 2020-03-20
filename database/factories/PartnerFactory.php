<?php

declare(strict_types=1);

/** @var Factory $factory */

use App\Partner;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Partner::class, function (Faker $faker) {
    return [
        'name'  => $faker->company,
        'email' => $faker->companyEmail,
    ];
});