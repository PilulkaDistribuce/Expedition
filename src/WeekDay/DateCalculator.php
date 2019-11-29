<?php
declare(strict_types=1);

namespace Pilulka\Expedition\WeekDay;

use Pilulka\Helper\DateTimeFactory;
use DateTimeInterface;
use DateTimeImmutable;

class DateCalculator
{
    private const SATURDAY = '6';
    private const SUNDAY = '7';

    /** @var DateTimeFactory */
    private $dateTimeFactory;
    
    /** @var array  */
    private $unavailableDay;

    public function __construct(UnavailableDay $unavailableDay, DateTimeFactory $dateTimeFactory)
    {
        $this->dateTimeFactory = $dateTimeFactory;
        $this->unavailableDay = $unavailableDay;
    }

    public function addWorkDays(DateTimeInterface $date, int $countDays): DateTimeImmutable
    {
        return $this->addOrSubtractWorkDays($date, abs($countDays), '+');
    }

    public function subtractWorkDays(DateTimeInterface $date, int $countDays): DateTimeImmutable
    {
        return $this->addOrSubtractWorkDays($date, abs($countDays), '-');
    }

    public function isWorkDay(DateTimeInterface $date): bool
    {
        return !$this->isWeekend($date) && !$this->isAvailable($date);
    }

    private function addOrSubtractWorkDays(DateTimeInterface $date, int $countDays, string $sign): DateTimeImmutable
    {
        $date = DateTimeImmutable::createFromFormat(\DATE_ISO8601, $date->format(\DATE_ISO8601));

        while ($countDays > 0) {
            while (!$this->isWorkDay($date)) {
                $date = $date->modify($sign . '1 day');
            }

            $date = $date->modify($sign . '1 day');
            $countDays--;
        }

        while (!$this->isWorkDay($date)) {
            $date = $date->modify($sign . '1 day');
        }

        return $date;
    }

    private function isWeekend(DateTimeInterface $date): bool
    {
        return in_array($date->format('N'), [self::SATURDAY, self::SUNDAY], true);
    }

    private function isAvailable(DateTimeInterface $date): bool
    {
        return in_array($date->format('j.n'), $this->unavailableDay->getAll(), true)
            || in_array($date->format('j.n.Y'), $this->unavailableDay->getAll(), true);
    }
}
