<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Models\SlateAddonMessage\Create as CreateSlateAddonMessage;
use GuzzleHttp\RequestOptions;

class SlateAddonMessagesService extends AbstractService
{
    /**
     * @param string $slateAddonUid
     * @param CreateSlateAddonMessage $model
     */
    public function push(string $slateAddonUid, CreateSlateAddonMessage $model): void
    {
        $url = $this->resolveEndpoint("/slate-addons/{$slateAddonUid}/message");

        $this->httpClient->post($url, [
            RequestOptions::JSON => $model->toArray()
        ]);
    }
}
