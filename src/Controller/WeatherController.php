<?php

namespace App\Controller;

// use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{countryCode?}', name: 'app_weather', requirements: ['city' => '[a-zA-Z]+', 'countryCode' => '[A-Z]{2}'])]
    public function city(string $city, ?string $countryCode, LocationRepository $locationRepository, WeatherUtil $weatherUtil): Response
    {
        $location = $locationRepository->myFuncFindBy($city, $countryCode);
        // $measurements = $measurementRepository->findByLocation($location);
        $measurements = $weatherUtil->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}



//<?php

//namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//
//class WeatherController extends AbstractController
//{
//    #[Route('/weather', name: 'app_weather')]
//    public function index(): Response
//    {
//        return $this->render('weather/index.html.twig', [
//            'controller_name' => 'WeatherController',
//        ]);
//    }
//}
