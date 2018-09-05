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
}
