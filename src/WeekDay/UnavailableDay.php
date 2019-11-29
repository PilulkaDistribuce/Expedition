<?php
declare(strict_types=1);

namespace Pilulka\Expedition\WeekDay;

use DateTimeInterface;

class UnavailableDay
{
    private $listOfDays;

    public function getAll(): array
    {
        return $this->listOfDays;
    }

    public function setUnavailableDate(DateTimeInterface $date): void
    {
        $this->listOfDays = $date->format('d.m.Y');
    }
}
