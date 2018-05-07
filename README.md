# AirSlate API PHP Client

This project makes it simple to integrate your application with [AirSlate Users Management Service](https://github.com/pdffiller/airslate-users-api) .

## Requirements

The following versions of PHP are supported:

- PHP 7.1
- PHP 7.2
- PHP 7.3

## Installation

The library can be installed using Composer.

Add vcs repository url to the `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:pdffiller/airslate-php-client.git"
    }
]
```

Install

```bash
composer require pdffiller/airslate-php-client
```

### Setting up for Laravel

Append Service Providers (usually the `config/app.php` file) as follows:

```php
'providers' => [
    //  ...
    AirSlate\ApiClient\Implementation\Laravel\Providers\ApiClientServiceProvider::class,
]
```

Next publish client configuration:

```bash
php artisan vendor:publish --tag=airslate-api
```

Then define environment variables to connect to AirSlate API:

```ini
; For development environment it is likely http://api.airslate.xyz
AS_API_BASE_URI=https://api.airslate.com
```

## Usage

Laravel users can get Client instance as usual by using `app()` facade:

```php
app(AirSlate\ApiClient\Client::class);
```

**Note:** First you have to register Service Provider as mentioned above.

Also you can make client instance directly as follows:

```php
use AirSlate\ApiClient\Client;

/**
 * An array of options to set on Client.
 * Option `token` is required.
 */
$config = [
    // Client oauth token.
    'token' => 'client-oauth-token',
];

/**
 * The $config argument must be either an array or Traversable.
 * Laravel users can use `app(AirSlate\ApiClient\Client::class)`.
 */
$client = Client::instance('https://api.airslate.xyz', $config);
```

### Retrieve authorized user
```php
/**
 * @var AirSlate\ApiClient\Entities\User $user
 */
$user = $client->users()->me();
```

### Invite users to organization
```php
/**
 * @var AirSlate\ApiClient\Entities\User[] $users
 */
$users = $client->users()->invite(string $organizationId, array $emails);
```

### With functionality
```php
/**
 * @param string|array $values
 */
 AbstractService::with($values);
```

Example:
```php
$client->users()
    ->with('organizations')
    ->me();
```

### Filtering functionality
```php
/**
 * @param string $key
 * @param string|array $values
 */
 AbstractService::addFilter(string $key, $values);
```

Example:
```php
$client->users()
    ->addFilter('id', ['E924D100-0000-0000-00009BC6', 'A783E100-0000-0000-00009BC6'])
    ->addFilter('email', 'blakov.oleksandr@pdffiller.team')
    ->all('BA0C8100-0000-0000-0000D981');
```
