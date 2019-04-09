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
     * @var
     */
    private $slateId;

    /**
     * @var
     */
    private $packetId;

    /**
     * @return Tag[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/flows/' . $this->slateId . '/packets/tags');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @return Tag[]
     * @throws \Exception
     */
    public function collectionInPacket()
    {
        $url = $this->resolveEndpoint('/flows/' . $this->slateId . '/packets/' . $this->packetId . '/tags');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Tag::createFromCollection($content);
    }

    /**
     * @param Assign $assign
     */
    public function assign(Assign $assign)
    {
        $url = $this->resolveEndpoint('/flows/' . $this->slateId . '/packets/' . $this->packetId . '/tags');

        $this->httpClient->post($url, [
            RequestOptions::JSON => $assign->toArray(),
        ]);
    }

    /**
     * @param Delete $assign
     */
    public function delete(Delete $assign)
    {
        $url = $this->resolveEndpoint('/flows/' . $this->slateId . '/packets/' . $this->packetId . '/tags');

        $this->httpClient->delete($url, [
            RequestOptions::JSON => $assign->toArray(),
        ]);
    }

    /**
     * @return mixed
     */
    public function getSlateId()
    {
        return $this->slateId;
    }

    /**
     * @param $slateId
     * @return TagsService
     */
    public function setSlateId($slateId): TagsService
    {
        $this->slateId = $slateId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPacketId()
    {
        return $this->packetId;
    }

    /**
     * @param $packetId
     * @return TagsService
     */
    public function setPacketId($packetId): TagsService
    {
        $this->packetId = $packetId;

        return $this;
    }
}
