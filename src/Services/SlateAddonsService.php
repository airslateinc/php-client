<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Addons\SlateAddon;
use AirSlate\ApiClient\Models\SlateAddon\Create as CreateSlateAddon;
use AirSlate\ApiClient\Models\SlateAddon\Update as UpdateSlateAddon;
use AirSlate\ApiClient\Models\SlateAddonMessage\Create as CreateSlateAddonMessage;
use Generator;
use GuzzleHttp\RequestOptions;

class SlateAddonsService extends AbstractService
{
    /**
     * @return SlateAddonFileService
     */
    public function slateAddonFiles(): SlateAddonFileService
    {
        return new SlateAddonFileService($this->httpClient);
    }

    /**
     * @param CreateSlateAddon $model
     * @return SlateAddon
     * @throws \Exception
     */
    public function create(CreateSlateAddon $model): SlateAddon
    {
        $url = $this->resolveEndpoint('/slate-addons');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateAddon::createFromOne($content);
    }

    /**
     * @param string $slateAddonId
     * @param UpdateSlateAddon $model
     * @return SlateAddon
     * @throws \Exception
     */
    public function update(string $slateAddonId, UpdateSlateAddon $model): SlateAddon
    {
        $url = $this->resolveEndpoint('/slate-addons/' . $slateAddonId);

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateAddon::createFromOne($content);
    }

    /**
     * @param string $slateAddonId
     * @return bool
     */
    public function delete(string $slateAddonId): bool
    {
        $url = $this->resolveEndpoint('/slate-addons/' . $slateAddonId);

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $slateAddonId
     * @return SlateAddon
     * @throws \Exception
     */
    public function get(string $slateAddonId): SlateAddon
    {
        $url = $this->resolveEndpoint('/slate-addons/' . $slateAddonId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateAddon::createFromOne($content);
    }

    /**
     * @param string $slateAddonUid
     * @param CreateSlateAddonMessage $model
     * @return bool
     */
    public function pushMessage(string $slateAddonUid, CreateSlateAddonMessage $model): bool
    {
        $url = $this->resolveEndpoint("/slate-addons/{$slateAddonUid}/message");

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $model->toArray()
        ]);

        return $response->getStatusCode() === 200;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/slate-addons');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return SlateAddon::createFromCollection($content);
    }

    /**
     * @return Generator|SlateAddon[]
     */
    public function collectionIterator(): Generator
    {
        $url = $this->resolveEndpoint('/slate-addons');
        yield from $this->pagination()->resolve($url, new SlateAddon());
    }
}
