<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Measurement;

class MeasurementTest extends TestCase
{

    public function dataGetFahrenheit(): array
    {
        return [
            [0.5, 32.9],
            [1.5, 34.7],
            [2.5, 36.5],
            [3.5, 38.3],
            [4.5, 40.1],
            [5.5, 41.9],
            [6.5, 43.7],
            [7.5, 45.5],
            [8.5, 47.3],
            [9.5, 49.1],
        ];
    }

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setCelsius($celsius);

        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit());
    }
}