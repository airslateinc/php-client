<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Tag;
use AirSlate\ApiClient\Models\Tag\Assign;
use AirSlate\ApiClient\Models\Tag\Delete;
use GuzzleHttp\RequestOptions;

/**
 * Class TagsService
 * @package AirSlate\ApiClient\Services
 */
class TagsService extends AbstractService
{
    /**
     * @param string $slateId
     * @return Tag[]
     * @throws \Exception
     */
    public function collection(string $slateId): array
    {
        $url = $this->resolveEndpoint('/flows/' . $slateId . '/packets/tags');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @param string $packetId
     * @return Slate[]
     * @throws \Exception
     */
    public function collectionInPacket(string $slateId, string $packetId)
    {
        $url = $this->resolveEndpoint('/flows/' . $slateId . '/packets/' . $packetId . '/tags');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @param string $packetId
     * @param Assign $assign
     * @return Slate[]
     * @throws \Exception
     */
    public function assign(string $slateId, string $packetId, Assign $assign)
    {
        $url = $this->resolveEndpoint('/flows/' . $slateId . '/packets/' . $packetId . '/tags');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $assign->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @param string $packetId
     * @param Delete $assign
     * @return bool
     */
    public function delete(string $slateId, string $packetId, Delete $assign)
    {
        $url = $this->resolveEndpoint('/flows/' . $slateId . '/packets/' . $packetId . '/tags');

        $response = $this->httpClient->delete($url, [
            RequestOptions::JSON => $assign->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
