<?php

namespace App\Http\Controllers;

use App\services\WeatherInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class WeatherController
 * @package App\Http\Controllers
 */
class WeatherController extends Controller
{
    /**
     * @var WeatherInterface
     */
    private $weather;

    public function __construct(WeatherInterface $weather)
    {
        $this->weather = $weather;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $weather = $this->weather->get();
        return view('weather.index', compact('weather'));
    }

}
