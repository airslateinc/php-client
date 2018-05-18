# AirSlate API PHP Client

This project makes it simple to integrate your application with:
 - [AirSlate Users Management Service](https://github.com/pdffiller/airslate-users-api)

## Requirements

PHP 7.1 or newer

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

## Entity manager

Entity manager is main object which controls communication with 3rd party REST api where JSON is used as main data type.
It's responsible for saving objects to, and fetching objects from, the API.

Overal idea has been taken from Doctrine ORM, where entities are responsible for row data and table,
which will be used for CRUD operations.

Each entity describes:
- API resorce url (via HttpEntity annotation),
- API payload (via properties and theirs types),
- API response type (via ResponseType annotation, optional).

Developers can get EntityManager instance by using DI container via `app()` helper function:

```php
app(AirSlate\ApiClient\Services\EntityManager::class);
```

### Entity Manager Usage 

### Create Slate
```php
$slateEntity = new Slate();
$slateData = new Slate\SlateData();
$slateAttributes = new Slate\SlateAttributes();
$slateAttributes->setName('New slate via entity manager ' . rand(1, 9999));
$slateAttributes->setDescription('This is new slate via entity manager and seems it works...' . rand(1, 9999));
$slateEntity->setData($slateData);
$slateData->setAttributes($slateAttributes);

$headers = [
    'Organization-Domain' => 'organization-sub-domain'
];
/** @var Slate $slateEntity */
$slateEntity = $entityManager->create($slateEntity, [], [], $headers);
```

### Retrieve Slate
```php
$headers = [
    'Organization-Domain' => 'organization-sub-domain'
];
/** @var Slate $slateEntity */
$slateEntity = $entityManager->get(Slate::class, ['id' => 'slareId'], [], $headers);
```

### Retrieve Slates collection
```php
$headers = [
    'Organization-Domain' => 'organization-sub-domain'
];
/** @var Slate\SlateCollection $slateEntity */
$slateCollection = $entityManager->get(Slate\SlateCollection::class, [], [], $headers);
```

### Invite users to organization
```php
$invite = new Invite();
$invite->addEmail('test@pdffiller.team');
$userCollection = $entityManager->create(
    $invite,
    [
        'orgId' => 'organizationId'
    ]
);
```

### Entities

We have implemented 3 base entity types, which you able to use in case,
if you don't want to describe your entity strucutre.
In general these entities are describing base properties for JSON API strucutre.

When you prepare entity to communicate with API endpoint you are able to define
- Relative end point url
- Type which will be used to map response (for cases when request and response are different for the same API resource).

```php
namespace AirSlate\ApiClient\Entity;

use AirSlate\ApiClient\Entity\Invite\InviteData;
use JMS\Serializer\Annotation as Serializer;
use AirSlate\ApiClient\Services\EntityManager\Annotation\HttpEntity;
use AirSlate\ApiClient\Services\EntityManager\Annotation\ResponseType;

/**
 * Class Invite
 * @package AirSlate\ApiClient\Entity
 *
 * @HttpEntity("organizations/{orgId}/users/invite")
 * @ResponseType("AirSlate\ApiClient\Entity\User\UserCollection")
 * @Serializer\ExclusionPolicy("all")
 */
class Invite extends BaseEntity
{
    /**
     * @var array
     *
     * @Serializer\Expose()
     * @Serializer\Type("AirSlate\ApiClient\Entity\Invite\InviteData")
     */
    protected $data;
}
```
Data from invite entity will be used for request payload
API url: organizations/{orgId}/users/invite
Response type: AirSlate\ApiClient\Entity\User\UserCollection

### P.S.
We don't have time to describe all available resources in entities, but each team will join to this activity and 
do it independantly.

What is next:
- Parallelization for http requests
- Possiblity to upload files and send multipart requests (via entites of course)
 