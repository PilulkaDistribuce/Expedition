<?php
declare(strict_types=1);

namespace Pilulka\Expedition\Helper;

class DateTimeFactory
{
    public function createImmutable(string $modify = 'now'): DateTimeImmutable
    {
        return new DateTimeImmutable($modify);
    }
    
    public function create(string $modify = 'now'): DateTime
    {
        return new DateTime($modify);
    }

    public function createFromFormat(string $format, string $time): DateTime
    {
        return DateTime::createFromFormat($format, $time);
    }
}
