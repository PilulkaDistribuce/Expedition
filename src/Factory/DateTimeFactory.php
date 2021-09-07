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
        $dateTime = DateTime::createFromFormat($format, $time);
        if ($dateTime === false) {
            throw new \RuntimeException('Cannot create DateTime object');
        }

        return $dateTime;
    }

    /**
     * @param string $format
     * @param string $time
     * @return DateTimeImmutable
     */
    public function createImmutableFromFormat(string $format, string $time): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat($format, $time);
        if ($dateTime === false) {
            throw new \RuntimeException('Cannot create DateTimeImmutable object');
        }

        return $dateTime;
    }
}
