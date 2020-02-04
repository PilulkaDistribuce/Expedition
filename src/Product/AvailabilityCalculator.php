<?php
declare(strict_types=1);

namespace Pilulka\Expedition\Product;

use DateTimeInterface;
use Pilulka\Expedition\Factory\DateTimeFactory;
use Pilulka\Expedition\WeekDay\DateCalculator;
use DateTimeImmutable;

class AvailabilityCalculator
{
    /** @var DateTimeFactory */
    private $dateTimeFactory;

    /** @var DateCalculator  */
    private $dateCalculator;

    public function __construct(DateTimeFactory $dateTimeFactory, DateCalculator $dateCalculator)
    {
        $this->dateTimeFactory = $dateTimeFactory;
        $this->dateCalculator = $dateCalculator;
    }

    public function calculate(int $availabilityPeriod, DateTimeInterface $since = null): DateTimeImmutable
    {
        if ($since === null) {
            $since = $this->dateTimeFactory->createImmutable();
        }

        $hoursToAdd = $availabilityPeriod % 24;
        $daysToAdd = intval(floor($availabilityPeriod / 24));

        $date = $this->dateCalculator->addWorkDays($since, $daysToAdd);
        $date = $date->modify("+{$hoursToAdd} hours");

        // convert to work day
        return $this->dateCalculator->addWorkDays($date, 0);
    }
}
