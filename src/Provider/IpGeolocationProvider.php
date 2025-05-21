<?php

declare(strict_types=1);

namespace GeoClock\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

readonly class IpGeolocationProvider
{
    private Client $client;

    public function __construct(private string $apiKey)
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException|\RuntimeException
     * @throws \DateMalformedStringException|\DateInvalidTimeZoneException
     */
    public function getTimeByIp(string $ip): \DateTimeImmutable
    {
        $response = $this->client->get('https://api.ipgeolocation.io/timezone', [
            'query' => [
                'apiKey' => $this->apiKey,
                'ip' => $ip,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if (!isset($data['date_time']) || !isset($data['timezone'])) {
            throw new \RuntimeException('Invalid response from IPGeolocation API');
        }

        return new \DateTimeImmutable($data['date_time'], new \DateTimeZone($data['timezone']));
    }
}
