<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use Generator;
use AirSlate\ApiClient\Http\Client;
use AirSlate\ApiClient\Entities\BaseEntity;

class PaginationResolver
{
    /** @var Client */
    private $httpClient;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->httpClient = $client;
    }

    /**
     * @param string $url
     * @param string $entityClass
     * @return Generator
     */
    public function resolve(string $url, string $entityClass): Generator
    {
        $page = 0;

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            $currentPage = $content['meta']['current_page'] ?? null;

            $lastPage = $content['meta']['last_page'] ?? null;

            /** @var $entityClass BaseEntity */
            yield from $entityClass::createFromCollection($content);
        } while ($this->hasMorePages($currentPage, $lastPage));
    }

    /**
     * @param int|null $currentPage
     * @param int|null $lastPage
     * @return bool
     */
    private function hasMorePages(?int $currentPage, ?int $lastPage): bool
    {
        if ($currentPage === null || $lastPage === null) {
            return false;
        }

        return $currentPage < $lastPage;
    }
}
