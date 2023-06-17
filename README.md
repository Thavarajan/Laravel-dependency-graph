# Laravel Dependency Graph

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrtech/laravel-dependency-graph.svg?style=flat-square)](https://packagist.org/packages/mrtech/laravel-dependency-graph)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mrtech/laravel-dependency-graph/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mrtech/laravel-dependency-graph/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mrtech/laravel-dependency-graph/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mrtech/laravel-dependency-graph/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mrtech/laravel-dependency-graph.svg?style=flat-square)](https://packagist.org/packages/mrtech/laravel-dependency-graph)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require mrtech/laravel-dependency-graph
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-dependency-graph-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-dependency-graph-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-dependency-graph-views"
```

## Usage

```php
$laravelDependencyGraph = new MRTech\LaravelDependencyGraph();
echo $laravelDependencyGraph->echoPhrase('Hello, MRTech!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Thavarajan.M](https://github.com/Thavarajan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
