<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\SlateAddonMessage\Create as CreateSlateAddonMessage;
use GuzzleHttp\RequestOptions;

class SlateAddonMessagesService extends AbstractService
{
    /**
     * @param CreateSlateAddonMessage $model
     */
    public function push(CreateSlateAddonMessage $model): void
    {
        $url = $this->resolveEndpoint("/slate-addons/{$model->getSlateAddonId()}/message");

        $this->httpClient->post($url, [
            RequestOptions::JSON => $model->toArray()
        ]);
    }
}
