# AirSlate API PHP Client

This project makes it simple to integrate your application with:
 - [AirSlate Users Management Service](https://github.com/pdffiller/airslate-users-api)

## Requirements

PHP 7.1 or newer

## Installation

The library can be installed using Composer.

Add vcs repository url to the `composer.json`:

```json
{
  "repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:pdffiller/airslate-php-client.git"
    }
  ]
}
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
AS_API_BASE_URI=<airslate-domain>
```

## Entity manager

Install

```bash
composer require pdffiller/airslate-php-client:dev-entity-manager
```


Entity manager is main object which controls communication with 3rd party REST api where JSON is used as main data type.
It's responsible for saving objects to, and fetching objects from, the API.

Overall idea has been taken from Doctrine ORM, where entities are responsible for row data and table, which will be used for CRUD operations.

Each entity describes:
- API resource url (via HttpEntity annotation),
- API payload (via properties and theirs types),
- API response type (via ResponseType annotation, optional).

Developers can get EntityManager instance by using DI container via `app()` helper function:

```php
app(AirSlate\ApiClient\EntityManager::class);
```

### Entity Manager Usage 

### Create Slate
```php
$slateEntity = new Slate();
$slateData = new Slate\SlateData();
$slateAttributes = new Slate\SlateAttributes();
$slateAttributes->setName('New slate via entity manager ' . rand(1, 9999));
$slateAttributes->setDescription('This is new slate via entity manager and seems it works...' . rand(1, 9999));
$slateData->setAttributes($slateAttributes);
$slateEntity->setData($slateData);

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
$slateEntity = $entityManager->get(Slate::class, ['id' => 'slateId'], [], $headers);
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
if you don't want to describe your entity structure.
In general these entities are describing base properties for JSON API structure.

When you prepare entity to communicate with API endpoint you are able to define
- Relative endpoint url
- Type which will be used to map response (for cases when request and response are different for the same API resource).

```php
namespace AirSlate\ApiClient\Entity;

use AirSlate\ApiClient\Entity\Invite\InviteData;
use JMS\Serializer\Annotation as Serializer;
use AirSlate\ApiClient\EntityManager\Annotation\HttpEntity;
use AirSlate\ApiClient\EntityManager\Annotation\ResponseType;

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

##### Entity annotations
Available annotations:
 - `HttpEntity("examples/{id}")` - this annotation allows to specified endpoint URL with placeholders if needed. Example: 
 ```php
 /**
  * @HttpEntity("examples/{exampleId}")
  */
 class Example {}
 
 /**
  * Request will be send to 
  * GET examples/12345
  */
 $entityManager->get(Example::class, ['exampleId' => 12345])
 ```
 - `ResponseType("Entity\Type")` - this annotation allows to specify response type in case if request and response types are different.

### Serialization
We use [JMS\Serializer](https://jmsyst.com/libs/serializer) for serialization process.
 
Supported serialization format:
 - json
 
##### Serializer annotations
All annotations, except `xml`-annotations and `@Group`-annotation, are allowed. 
 

### P.S.
We don't have time to describe all available resources in entities, but each team will join to this activity and 
do it independently.

What is next:
- Parallelization for http requests
- Possibility to upload files and send multipart requests (via entities of course)
 