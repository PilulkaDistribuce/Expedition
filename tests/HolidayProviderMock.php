<?php

declare(strict_types=1);

namespace Pilulka\Expedition\Tests;

use DateTimeInterface;
use HolidayProvider\HolidayProvider;
use HolidayProvider\HolidayProviderException;

class HolidayProviderMock extends HolidayProvider
{
    /** @var string[] */
    private $holidays;

    /**
     * @param string $country
     * @param string[] $holidays
     * @throws HolidayProviderException
     */
    public function __construct(string $country, array $holidays)
    {
        parent::__construct($country);

        $this->holidays = $holidays;
    }

    public function isHoliday(DateTimeInterface $dateTime): bool
    {
        $dateTimeFormat = 'Y-m-d';

        return in_array($dateTime->format($dateTimeFormat), $this->holidays, true);
    }
}
