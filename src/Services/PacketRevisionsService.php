<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\PacketRevision;

/**
 * Class PacketRevisionsService
 * @package AirSlate\ApiClient\Services
 */
class PacketRevisionsService extends AbstractService
{
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/packet-revisions');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketRevision::createFromCollection($content);
    }
}
