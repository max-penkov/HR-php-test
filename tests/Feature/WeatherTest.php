<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\services\WeatherInterface;
use Tests\TestCase;

/**
 * Class WeatherTest
 * @package Tests\Feature
 */
class WeatherTest extends TestCase
{
    /**
     * @test
     */
    public function can_see_weater_for_bryansk()
    {
        $this->disableExceptionHandling();
        $service = app(WeatherInterface::class);
        $forecast = $service->get();
        $this->assertNotNull($forecast);
    }
}