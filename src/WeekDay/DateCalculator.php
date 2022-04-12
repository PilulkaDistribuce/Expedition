<?php
declare(strict_types=1);

namespace Pilulka\Expedition\WeekDay;

use DateTimeInterface;
use DateTimeImmutable;
use HolidayProvider\HolidayProvider;
use Pilulka\Expedition\Factory\DateTimeFactory;

class DateCalculator
{

    /** @var DateTimeFactory */
    private $dateTimeFactory;

    /** @var HolidayProvider */
    private $holidayProvider;

    private $addWorkDaysCache = [];

    public function __construct(HolidayProvider $holidayProvider, DateTimeFactory $dateTimeFactory)
    {
        $this->dateTimeFactory = $dateTimeFactory;
        $this->holidayProvider = $holidayProvider;
    }

    public function addWorkDays(DateTimeInterface $date, int $countDays): DateTimeImmutable
    {
        $cacheKey = "{$date->getTimestamp()}__$countDays";
        $cacheValue = $this->addWorkDaysCache[$cacheKey] ?? null;
        if ($cacheValue !== null) {
            return $cacheValue;
        }

        return $this->addWorkDaysCache[$cacheKey] = $this->addOrSubtractWorkDays($date, abs($countDays), '+');
    }

    public function subtractWorkDays(DateTimeInterface $date, int $countDays): DateTimeImmutable
    {
        return $this->addOrSubtractWorkDays($date, abs($countDays), '-');
    }

    public function isWorkDay(DateTimeInterface $date): bool
    {
        return !$this->holidayProvider->isWeekendOrHoliday($date);
    }

    private function addOrSubtractWorkDays(DateTimeInterface $date, int $countDays, string $sign): DateTimeImmutable
    {
        $date = $this->dateTimeFactory->createImmutableFromFormat(\DATE_ATOM, $date->format(\DATE_ATOM));

        while ($countDays > 0) {
            while (!$this->isWorkDay($date)) {
                $date = $date->modify($sign . '1 day');
            }

            $date = $date->modify($sign . '1 da
