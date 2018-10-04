<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Addons\AddonFile as AddonFileEntity;

class AddonFileService extends AbstractService
{
    /**
     * @param string $addonFileId
     * @return AddonFileEntity
     * @throws \Exception
     */
    public function one(string $addonFileId): AddonFileEntity
    {
        $url = $this->resolveEndpoint('/addon-files/' . $addonFileId);
        
        $response = $this->httpClient->get($url);
        
        $content = \GuzzleHttp\json_decode($response->getBody(), true);
        
        return AddonFileEntity::createFromOne($content);
    }

    /**
     * @param string $addonFileId
     * @return \Psr\Http\Message\StreamInterface
     */
    public function download(string $addonFileId)
    {
        $url = $this->resolveEndpoint("/addon-files/$addonFileId/download");

        $response = $this->httpClient->get($url);

        return $response->getBody();
    }
}
