<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    private MeasurementRepository $measurementRepository;
    private LocationRepository $locationRepository;

    public function __construct(
        MeasurementRepository $measurementRepository,
        LocationRepository $locationRepository
    ) {
        $this->measurementRepository = $measurementRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * Retrieves weather data for a given location.
     *
     * @param Location $location
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementRepository->findByLocation($location);
    }

    /**
     * Retrieves weather data for a given country code and city.
     *
     * @param string $countryCode
     * @param string $city
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->myFuncFindBy($city, $countryCode);

        return $location ? $this->getWeatherForLocation($location) : [];
    }
}
