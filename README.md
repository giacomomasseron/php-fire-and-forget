# Execute Fire and Forget requests with PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/giacomomasseron/php-fire-and-forget.svg?style=flat-square)](https://packagist.org/packages/giacomomasseron/php-fire-and-forget)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/giacomomasseron/php-fire-and-forget/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/giacomomasseron/php-fire-and-forget/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/giacomomasseron/php-fire-and-forget/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/giacomomasseron/php-fire-and-forget/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/giacomomasseron/php-fire-and-forget.svg?style=flat-square)](https://packagist.org/packages/giacomomasseron/php-fire-and-forget)

Execute fire and forget requests.

It handles:
- Get, Post ,Put ,Delete requests
- Custom headers
- Bearer token authentication


## Installation

You can install the package via composer:

```bash
composer require giacomomasseron/php-fire-and-forget
```

## Usage

```php
\GiacomoMasseroni\FireAndForget\FireAndForget::get($url);
```

If you want to send a POST request, you can use the `post` method:
```php
\GiacomoMasseroni\FireAndForget\FireAndForget::withHeaders([
        'X-Header' => 'Test',
        'X-Header2' => 'Test2',
    ])->post($url);
```

If you need to use a Bearer token for authentication, you can do it like this:
```php
\GiacomoMasseroni\FireAndForget\FireAndForget::withBearerToken('your_token')->post($url);
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

- [Giacomo Masseroni](https://github.com/giacomomasseron)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
