# Laravel Ship24

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wheesnoza/laravel-ship24.svg?style=flat-square)](https://packagist.org/packages/wheesnoza/laravel-ship24)
[![Total Downloads](https://img.shields.io/packagist/dt/wheesnoza/laravel-ship24.svg?style=flat-square)](https://packagist.org/packages/wheesnoza/laravel-ship24)
[![GitHub Issues](https://img.shields.io/github/issues/wheesnoza/laravel-ship24.svg?style=flat-square)](https://github.com/wheesnoza/laravel-ship24/issues)

Laravel Ship24 is a powerful package that integrates the Ship24 API seamlessly into your Laravel application. With this package, you can easily track shipments, create new trackers, and manage your tracking information.

## Features

- **Easy Installation**: Quickly set up and integrate the Ship24 API.
- **API Integration**: Full support for Ship24's tracking API.
- **Extensible**: Customize and extend the package according to your needs.
- **Compatible with Laravel 10 and 11**: Works with the latest versions of Laravel.

## Installation

You can install the package via Composer:

```bash
composer require wheesnoza/laravel-ship24
```

After installing, you may publish the configuration file:

```bash
php artisan vendor:publish --tag=config
```

## Configuration

The package requires an API token and URI from Ship24, which you should add to your `.env` file:

```env
SHIP24_ACCESS_TOKEN=your-access-token
SHIP24_URI=https://api.ship24.com/public/v1
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
