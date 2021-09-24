<?php

declare(strict_types=1);

namespace Pilulka\Expedition\WeekDay;

/**
 * Pico nemaz to, ten interface trebas pouziva kod, kde je tenhle balik zavislosti (v realu trebas stock.data) !!
 */
interface UnavailableDay
{
    /** @return array<string, string> */
    public function getAll(): array;
}
