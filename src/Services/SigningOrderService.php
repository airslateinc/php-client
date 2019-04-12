<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\PacketSigningOrder;
use AirSlate\ApiClient\Models\SigningOrder\Create;
use GuzzleHttp\RequestOptions;

/**
 * Class SigningOrderService
 * @package AirSlate\ApiClient\Services
 */
class SigningOrderService extends AbstractService
{
    /**
     * @param string $flowUid
     * @param string $packetUid
     * @param Create $signingOrder
     * @return PacketSigningOrder
     * @throws \Exception
     */
    public function update(string $flowUid, string $packetUid, Create $signingOrder)
    {
        $url = $this->resolveEndpoint("/flows/{$flowUid}/packets/{$packetUid}/signing-order");

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $signingOrder->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return PacketSigningOrder::createFromOne($content);
    }
}
