<?php

namespace GeoClock\Tests;

use PHPUnit\Framework\TestCase;

final class GeoClockTest extends TestCase
{
    public function testNowReturnsDateTimeImmutable(): void
    {
        $clock = new TestableGeoClock(function () {
            return new \DateTimeImmutable('2025-01-01T12:00:00+02:00');
        });

        $now = $clock->now();
        $this->assertInstanceOf(\DateTimeImmutable::class, $now);
    }

    public function testNowUsesProvidedIp(): void
    {
        $clock = new TestableGeoClock(function () {
            return new \DateTimeImmutable('2025-01-01T08:00:00+00:00');
        });

        $now = $clock->now();
        $this->assertSame('08', $now->format('H'));
    }

    public function testNowFallsBackToUtcOnFailure(): void
    {
        $clock = new TestableGeoClock(function () {
            throw new \RuntimeException('Simulated failure');
        });

        $now = $clock->now();
        $this->assertSame('UTC', $now->getTimezone()->getName());
    }

    public function testNowReturnsDifferentTimeForIp_1_1_1_1(): void
    {
        $clock = new StubGeoClock('1.1.1.1');
        $now = $clock->now();

        $this->assertSame('10', $now->format('H'));
    }

    public function testNowReturnsDifferentTimeForIp_8_8_8_8(): void
    {
        $clock = new StubGeoClock('8.8.8.8');
        $now = $clock->now();

        $this->assertSame('15', $now->format('H'));
    }
}
