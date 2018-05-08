<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\FederatedSearch;

/**
 * Class FederatedSearchService
 * @package AirSlate\ApiClient\Services
 */
class FederatedSearchService extends AbstractService
{
    /**
     * @param string $slateUid
     * @param string $keyword
     * @return array
     * @throws \Exception
     */
    public function search(string $slateUid, string $keyword): array
    {
        $response = $this->httpClient->get($this->resolveEndpoint('/search'), [
            'query' => [
                'slate_id' => $slateUid,
                'keyword' => $keyword,
            ],
        ]);
        $response = \GuzzleHttp\json_decode($response->getBody(), true);

        return FederatedSearch::createFromCollection($response);
    }

    /**
     * @param $path
     * @return string
     */
    protected function resolveEndpoint($path): string
    {
        return ltrim($path, '/');
    }
}
