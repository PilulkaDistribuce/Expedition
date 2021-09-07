<?php

declare(strict_types=1);

namespace Pilulka\Expedition\Tests;

use DateTime;
use HolidayProvider\HolidayProvider;
use HolidayProvider\HolidayProviderException;
use PHPUnit\Framework\TestCase;
use Pilulka\Expedition\Factory\DateTimeFactory;
use Pilulka\Expedition\Product\AvailabilityCalculator;
use Pilulka\Expedition\WeekDay\DateCalculator;

class AvailabilityCalculatorTest extends TestCase
{
    /**
     * @param DateTime $startDate
     * @param int $hours
     * @param DateTime $expectedEndDate
     * @param string[] $holidays
     *
     * @dataProvider provideCalculate
     * @throws HolidayProviderException
     */
    public function testCalculate(
        DateTime $startDate,
        int $hours,
        DateTime $expectedEndDate,
        array $holidays
    ): void {
        $calculatorCz = new AvailabilityCalculator(
            new DateTimeFactory(),
            new DateCalculator(
                new HolidayProviderMock(HolidayProvider::COUNTRY_CZ, $holidays),
                new DateTimeFactory()
            )
        );

        $calculatedEndDate = $calculatorCz->calculate($hours, $startDate);
        $this->assertSame($expectedEndDate->format('Y-m-d H:i:s'), $calculatedEndDate->format('Y-m-d H:i:s'));
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function provideCalculate(): array
    {
        return [
            'nothing' => [
                new DateTime('2021-08-11'), // wednesday
                0 * 24,
                new DateTime('2021-08-11'),
                [],
            ],
            'simple' => [
                new DateTime('2021-08-11'),
                1 * 24,
                new DateTime('2021-08-12'),
                [],
            ],
            'one holiday first' => [
                new DateTime('2021-08-11'),
                1 * 24,
                new DateTime('2021-08-13'),
                ['2021-08-11'],
            ],
            'one holiday last' => [
                new DateTime('2021-08-11'),
                1 * 24,
                new DateTime('2021-08-13'),
                ['2021-08-12'],
            ],
            'one holiday extra' => [
                new DateTime('2021-08-11'),
                1 * 24,
                new DateTime('2021-08-12'),
                ['2021-08-13'],
            ],
            'complex' => [
                new DateTime('2021-08-11'), // wednesday
                5 * 24,
                new DateTime('2021-08-20'), // next friday
                [
                    '2021-08-13', // friday
                    '2021-08-14', // saturday
                    '2021-08-16', // monday
                ],
            ],
        ];
    }
}
