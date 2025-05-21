<?php

declare(strict_types=1);

namespace GeoClock;

use GeoClock\Provider\IpGeolocationProvider;
use Psr\Clock\ClockInterface;
use GeoClock\Service\IpDetector;

class GeoClock implements ClockInterface
{
    private IpGeolocationProvider $provider;
    private IpDetector $ipDetector;
    private ?string $ip;

    public function __construct(string $apiKey, ?string $ip = null)
    {
        $this->provider = new IpGeolocationProvider($apiKey);
        $this->ipDetector = new IpDetector();
        $this->ip = $ip;
    }

    /**
     * Returns the current time based on the injected callback logic.
     *
     * If the callback fails (e.g. simulates an unreachable provider),
     * this implementation falls back to returning the current UTC time.
     *
     * Note: In a real-world application, you may choose to throw the exception
     * instead of suppressing it — depending on business requirements.
     *
     * This fallback strategy is intentional and chosen for the purpose of this test.
     */
    public function now(): \DateTimeImmutable
    {
        try {
            $ip = $this->ip ?? $this->ipDetector->detect();

            return $this->provider->getTimeByIp($ip);
        } catch (\Throwable) {
            return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        }
    }
}