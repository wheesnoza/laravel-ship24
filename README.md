# Laravel Ship24

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wheesnoza/laravel-ship24.svg?style=flat-square)](https://packagist.org/packages/wheesnoza/laravel-ship24)
[![Total Downloads](https://img.shields.io/packagist/dt/wheesnoza/laravel-ship24.svg?style=flat-square)](https://packagist.org/packages/wheesnoza/laravel-ship24)
[![GitHub Issues](https://img.shields.io/github/issues/wheesnoza/laravel-ship24.svg?style=flat-square)](https://github.com/wheesnoza/laravel-ship24/issues)

Laravel Ship24 is a powerful package that integrates the Ship24 API seamlessly into your Laravel application. With this package, you can easily track shipments, create new trackers, and manage your tracking information.

## Features

- **Easy Installation**: Quickly set up and integrate the Ship24 API.
- **API Integration**: Full support for Ship24's tracking API.
- **Extensible**: Customize and extend the package according to your needs.
- **Compatible with Laravel 11 and 12**: Works with the latest versions of Laravel.

## Compatibility

- Laravel: 11, 12
- PHP: 8.2+
- Dependencies: `illuminate/contracts`, `spatie/laravel-data` are aligned for Laravel 11/12 support

## Support Policy

- Latest Laravel major version (currently 12) is supported.
- Previous major version (11) is supported when compatible with current dependencies.
- Compatibility validation status is documented below.

## Verification Status

- Laravel 12: Verified via package tests (Service/Facade regression, request configuration)
- Laravel 11: Supported via dependency constraints; verification ongoing

## Known Limitations

- Ship24 API availability impacts runtime behavior; errors are surfaced from the HTTP client.
- Compatibility is limited to documented Laravel/PHP versions.

## Breaking Changes

- No breaking changes introduced for Laravel 12 compatibility.
- If breaking changes are required in the future, alternatives and migration steps will be documented in the release notes.

## Installation

You can install the package via Composer:

```bash
composer require wheesnoza/laravel-ship24
```

After installing, you may publish the configuration file:

```bash
php artisan vendor:publish --provider="Wheesnoza\Ship24\Providers\Ship24ServiceProvider" --tag=config
```

## Configuration

The package requires an API token, which you should add to your `.env` file:

```env
SHIP24_ACCESS_TOKEN=your-access-token
```

## Usage

### Retrieve a Tracker by ID

```php
use Wheesnoza\Ship24\Facades\Ship24;

$tracker = Ship24::tracker('TRACKER_ID');
```

### Retrieve Multiple Trackers

```php
use Wheesnoza\Ship24\Facades\Ship24;

$trackers = Ship24::trackers();
```

### Create a New Tracker

```php
use Wheesnoza\Ship24\Facades\Ship24;

$tracker = Ship24::createTracker('TRACKING_NUMBER');
```

## Testing

To run the tests, execute the following command:

```bash
composer test
```

## Contributing

Contributions are welcome! If you find a bug or have a feature request, please open an issue on [GitHub](https://github.com/wheesnoza/laravel-ship24/issues).

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
