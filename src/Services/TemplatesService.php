<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Template;
use AirSlate\ApiClient\Models\Template\Create;
use AirSlate\ApiClient\Models\Template\Update;
use GuzzleHttp\RequestOptions;

/**
 * Class TemplatesService
 * @package AirSlate\UsersManagement\Services
 */
class TemplatesService extends AbstractService
{
    protected $slateId;

    /**
     * @return Template[]
     * @throws \Exception
     */
    public function collection(): array
    {
        $url = $this->resolveEndpoint('/slates/' . $this->slateId . '/templates');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromCollection($content);
    }

    /**
     * @param string $templateId
     * @return Template
     * @throws \Exception
     */
    public function get(string $templateId): Template
    {
        $url = $this->resolveEndpoint('/slates/' . $this->slateId . '/templates/' . $templateId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @return mixed
     */
    public function getSlateId()
    {
        return $this->slateId;
    }

    /**
     * @param string $slateId
     * @return TemplatesService
     */
    public function setSlateId($slateId): TemplatesService
    {
        $this->slateId = $slateId;

        return $this;
    }

    /**
     * @param Create $slate
     * @return Template
     * @throws \Exception
     */
    public function create(Create $slate): Template
    {
        $url = $this->resolveEndpoint('/slates/' . $this->slateId . '/templates');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $slate->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }

    /**
     * @param Update $slate
     * @return Template
     * @throws \Exception
     */
    public function update(Update $slate): Template
    {
        $url = $this->resolveEndpoint('/slates/' . $this->slateId . '/templates');

        $response = $this->httpClient->patch($url, [
            RequestOptions::JSON => $slate->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Template::createFromOne($content);
    }
}
