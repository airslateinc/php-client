<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Tag;
use AirSlate\ApiClient\Models\Tag\Assign;
use AirSlate\ApiClient\Models\Tag\Delete;
use Generator;
use GuzzleHttp\RequestOptions;

/**
 * Class TagsService
 * @package AirSlate\ApiClient\Services
 */
class TagsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @return Tag[]
     * @throws \Exception
     */
    public function collection(string $flowUid): array
    {
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/packets/tags');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @return Generator
     */
    public function collectionIterator(string $flowUid): Generator
    {
        $page = 0;
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/packets/tags');

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield Tag::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
    }

    /**
     * @param string $flowUid
     * @param string $packetId
     * @return Tag[]
     * @throws \Exception
     */
    public function collectionInPacket(string $flowUid, string $packetId): array
    {
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/packets/' . $packetId . '/tags');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetId
     * @return Generator
     */
    public function collectionInPacketIterator(string $flowUid, string $packetId): Generator
    {
        $page = 0;
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/packets/' . $packetId . '/tags');

        do {
            $page++;

            $response = $this->httpClient->addQueryParam('page', $page)->get($url);

            $content = \GuzzleHttp\json_decode($response->getBody(), true);

            yield Tag::createFromCollection($content);
        } while ($content['meta']['current_page'] < $content['meta']['last_page']);
    }

    /**
     * @param string $flowUid
     * @param string $packetId
     * @param Assign $assign
     * @return Tag[]
     * @throws \Exception
     */
    public function assign(string $flowUid, string $packetId, Assign $assign): array
    {
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/packets/' . $packetId . '/tags');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $assign->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @param string $flowUid
     * @param string $packetId
     * @param Delete $assign
     * @return bool
     */
    public function delete(string $flowUid, string $packetId, Delete $assign): bool
    {
        $url = $this->resolveEndpoint('/flows/' . $flowUid . '/packets/' . $packetId . '/tags');

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $assign->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
