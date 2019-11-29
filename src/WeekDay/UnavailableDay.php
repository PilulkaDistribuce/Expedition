<?php
declare(strict_types=1);

namespace Pilulka\Expedition\WeekDay;

interface UnavailableDay
{
    public function getAll(): array;
}
