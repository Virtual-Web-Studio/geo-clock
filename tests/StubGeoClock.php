<?php

declare(strict_types=1);

namespace GeoClock\Tests;

use GeoClock\GeoClock;
use DateTimeImmutable;
use DateTimeZone;

final class StubGeoClock extends GeoClock
{
    public function __construct(private readonly string $ip)
    {
        parent::__construct('stub-api-key', $ip);
    }

    public function now(): DateTimeImmutable
    {
        return match ($this->ip) {
            '1.1.1.1' => new DateTimeImmutable('2025-01-01T10:00:00+00:00'),
            '8.8.8.8' => new DateTimeImmutable('2025-01-01T15:00:00+00:00'),
            default => new DateTimeImmutable('now', new DateTimeZone('UTC')),
        };
    }
}
