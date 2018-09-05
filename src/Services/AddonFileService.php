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
        $response = $this->httpClient->get('addon-files/' . $addonFileId);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);
        
        return AddonFileEntity::createFromOne($content);
    }
}
