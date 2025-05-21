<?php

declare(strict_types=1);

namespace GeoClock\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class IpDetector
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException|\RuntimeException
     */
    public function detect(): string
    {
        $response = $this->client->get('https://api.ipify.org?format=json');
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['ip'] ?? throw new \RuntimeException('Failed to detect external IP');
    }
}
