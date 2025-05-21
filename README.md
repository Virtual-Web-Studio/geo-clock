# GeoClock

GeoClock is a lightweight PHP library implementing the [PSR-20 `ClockInterface`](https://www.php-fig.org/psr/psr-20/).  
It provides the current time in the server’s geographical time zone using its public IP address.

## Features

- PSR-20 `ClockInterface` compatible
- Auto-detects public IP
- Returns current time in the detected time zone
- Supports overriding IP manually
- Easily replaceable providers (via Strategy pattern)

## Installation

```bash
composer require virtual-web-studio/geo-clock
