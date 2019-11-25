<?php
declare(strict_types=1);

namespace Pilulka\Expedition\Product;

use DateTimeInterface;
use Pilulka\Expedition\WeekDay\DateCalculator;
use Pilulka\Helper\DateTimeFactory;
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

        $daysToAdd = intval(ceil($availabilityPeriod / 24));

        return $this->dateCalculator->addWorkDays($since, $daysToAdd);
    }
}
