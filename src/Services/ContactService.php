<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Contact;
use Generator;

class ContactService extends AbstractService
{
    /**
     * @return Contact[]
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint("/address-book/search");

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Contact::createFromCollection($content);
    }

    /**
     * @return Generator
     */
    public function collectionIterator(): Generator
    {
        $url = $this->resolveEndpoint("/address-book/search");
        yield from $this->pagination()->resolve($url, Contact::class);
    }
}
