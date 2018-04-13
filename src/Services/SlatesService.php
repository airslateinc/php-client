<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Slate;
use AirSlate\ApiClient\Models\Slate\Create;
use GuzzleHttp\RequestOptions;

/**
 * Class SlatesService
 * @package AirSlate\UsersManagement\Services
 */
class SlatesService extends AbstractService
{
    /**
     * @return Slate[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/slates');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromCollection($content);
    }

    /**
     * @param string $slateId
     * @return Slate
     * @throws \Exception
     */
    public function get(string $slateId): Slate
    {
        $url = $this->resolveEndpoint('/slates/' . $slateId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }

    /**
     * @param string $slateId
     * @return PacketsService
     */
    public function packets(string $slateId): PacketsService
    {
        return (new PacketsService($this->httpClient))->setSlateId($slateId);
    }

    /**
     * @param string $slateId
     * @return TemplatesService
     */
    public function templates(string $slateId): TemplatesService
    {
        return (new TemplatesService($this->httpClient))->setSlateId($slateId);
    }

    /**
     * @param Create $slate
     * @return Slate
     * @throws \Exception
     */
    public function create(Create $slate): Slate
    {
        $url = $this->resolveEndpoint('/slates');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $slate->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Slate::createFromOne($content);
    }
}
