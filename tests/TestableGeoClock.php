<?php

declare(strict_types=1);

namespace GeoClock\Tests;

use GeoClock\GeoClock;

final class TestableGeoClock extends GeoClock
{
    public function __construct(private \Closure $timeCallback)
    {
        // parent::__construct requires an apiKey, but we bypass it
        // by setting an empty string and overriding the behavior entirely
        parent::__construct('fake-key');
    }

    public function now(): \DateTimeImmutable
    {
        try {
            return ($this->timeCallback)();
        } catch (\Throwable) {
            return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        }
    }
}
