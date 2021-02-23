<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\PacketRevisionRedirects\Update;
use GuzzleHttp\RequestOptions;

class PacketRevisionRedirectsService extends AbstractService
{
    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param string $revisionUid
     * @param Update $packetRevisionRedirect
     * @return bool
     */
    public function update(
        string $flowUid,
        string $packetUid,
        string $revisionUid,
        Update $packetRevisionRedirect
    ): bool {
        $url = $this->resolveEndpoint(
            "/flows/$flowUid/packets/$packetUid/revisions/$revisionUid/redirect"
        );
        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $packetRevisionRedirect->toArray(),
        ]);

        return $response && $response->getStatusCode() === 204;
    }
}
