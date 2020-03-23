<?php

declare(strict_types=1);

namespace App\services;

use GuzzleHttp\Client;

/**
 * Class WeatherService
 * @package App\services
 */
class WeatherHereService implements WeatherInterface
{
    private $appId;
    private $appCode;
    /**
     * @var string
     */
    private $url;
    /**
     * @var Client
     */
    private $client;
    private $lat;
    private $lng;

    public function __construct(
        $appCode,
        $appId,
        $lat,
        $lng,
        $url = 'https://weather.api.here.com/weather/1.0/report.json'
    ) {
        if (empty($appCode) && empty($appId)) {
            throw new \InvalidArgumentException('Here credentials must be set.');
        }

        $this->appCode = $appCode;
        $this->appId   = $appId;
        $this->url     = $url;
        $this->lat     = $lat;
        $this->lng     = $lng;
        $this->client  = new Client();
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $res = $this->client->get($this->url, [
            'query' => [
                'latitude'  => $this->lat,
                'longitude' => $this->lng,
                'product'   => 'forecast_hourly',
                'language' => 'ru',
                'app_id'    => $this->appId,
                'app_code'  => $this->appCode,
            ],
        ]);

        if ($res->getStatusCode() == 200) {
            $data     = $res->getBody()->getContents();
            $obj      = json_decode($data);
            $forecast = $obj->hourlyForecasts->forecastLocation;
            return $forecast;
        }
    }

}