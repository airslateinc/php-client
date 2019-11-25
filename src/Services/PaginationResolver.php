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
     * @param BaseEntity $entity
     * @return Generator
     */
    public function resolve(string $url, BaseEntity $entity): Generator
    {
        $page = 0;

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            $currentPage = $content['meta']['current_page'] ?? null;

            $lastPage = $content['meta']['last_page'] ?? null;

            yield from $entity::createFromCollection($content);
        } while ($this->checkCondition($currentPage, $lastPage));
    }

    /**
     * @param int|null $currentPage
     * @param int|null $lastPage
     * @return bool
     */
    private function checkCondition(?int $currentPage, ?int $lastPage): bool
    {
        if ($currentPage === null || $lastPage === null) {
            return false;
        }

        return $currentPage < $lastPage;
    }
}
