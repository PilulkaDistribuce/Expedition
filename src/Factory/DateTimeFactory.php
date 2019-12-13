<?php
declare(strict_types=1);

namespace Pilulka\Expedition\Factory;

use DateTimeImmutable;
use DateTime;
use Exception;

class DateTimeFactory
{
    /**
     * @param string $modify
     * @return DateTimeImmutable
     * @throws Exception
     */
    public function createImmutable(string $modify = 'now'): DateTimeImmutable
    {
        return new DateTimeImmutable($modify);
    }

    /**
     * @param string $modify
     * @return DateTime
     * @throws Exception
     */
    public function create(string $modify = 'now'): DateTime
    {
        return new DateTime($modify);
    }

    /**
     * @param string $format
     * @param string $time
     * @return DateTime
     */
    public function createFromFormat(string $format, string $time): DateTime
    {
        return DateTime::createFromFormat($format, $time);
    }

    /**
     * @param string $format
     * @param string $time
     * @return DateTimeImmutable
     */
    public function createImmutableFromFormat(string $format, string $time): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat($format, $time);

    }
}
