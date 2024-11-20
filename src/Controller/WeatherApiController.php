<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Service\WeatherUtil;
use App\Entity\Measurement;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $weatherUtil,
        #[MapQueryParameter('city')] string $city,
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('format')] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false
    ): Response {
        $measurements = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        if ($format === 'csv') {

            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }

            $csvContent = "city,country,date,celsius,fahrenheit\n";
            $csvContent .= implode(
                "\n",
                array_map(
                    fn(Measurement $m) => sprintf(
                        '%s,%s,%s,%s,%s',
                        $city,
                        $country,
                        $m->getDate()->format('Y-m-d'),
                        $m->getCelsius(),
                        $m->getFahrenheit()
                    ),
                    $measurements)
                );

            return new Response($csvContent, 200, [
                'Content-Type' => 'text/plain',
            ]);
        }

        if ($twig) {
            return $this->render('weather_api/index.json.twig', [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ]);
        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getCelsius(),
                'fahrenheit' => $m->getFahrenheit(),
            ], $measurements),

        ]);
    }
}
