# GeoClock

GeoClock is a lightweight PHP library implementing the [PSR-20 `ClockInterface`](https://www.php-fig.org/psr/psr-20/).

It provides the current time in the server’s geographical time zone using its public IP address, by querying the [`ipgeolocation.io`](https://ipgeolocation.io) API.

---

## Features

- PSR-20 compatible `ClockInterface`
- Returns accurate time based on geolocation
- Automatically detects the public IP of the server
- Allows manually overriding the IP address
- Falls back to UTC on error
- Minimal dependencies

---

## ⚠️ API Key Required

This library uses the [`ipgeolocation.io`](https://ipgeolocation.io) API to resolve timezone and current time.  
You **must provide a valid API key** when instantiating the clock.

To get an API key:

1. Register at [https://ipgeolocation.io](https://ipgeolocation.io)
2. Copy your key from the dashboard
3. Use it like this:

```php
use GeoClock\GeoClock;

$clock = new GeoClock('your_api_key');
echo $clock->now()->format('c'); // ISO 8601 output
```

You can also specify a known IP manually:
```php
$clock = new GeoClock('your_api_key', '8.8.8.8');
```

## Installation

Recommended (after stable tag is released):
```bash
composer require virtual-web-studio/geo-clock
```

Development version (if using dev-main):

```bash
composer require virtual-web-studio/geo-clock:dev-main --with-all-dependencies
```

## Testing
To run tests:

```bash
make test
```

## License
MIT — see LICENSE