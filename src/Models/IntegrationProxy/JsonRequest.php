<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\IntegrationProxy;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class JsonRequest extends AbstractModel
{
    /**
     * @param string $slateAddonIntegration
     * @param string $httpMethod
     * @param string $url
     */
    public function __construct(
        string $slateAddonIntegration,
        string $httpMethod,
        string $url
    ) {
        parent::__construct([
            'type' => EntityType::INTEGRATION_REQUESTS,
            'attributes' => [
                'http_method' => $httpMethod,
                'action' => $url,
                'headers' => [],
                'arguments' => []
            ],
            'relationships' => [
                'slate_addon_integration' => [
                    'data' => [
                        'type' => EntityType::SLATE_ADDON_INTEGRATION,
                        'id' => $slateAddonIntegration

                    ]
                ]
            ]
        ]);
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): self
    {
        $this->data['attributes']['headers'] = $headers;

        return $this;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function setQuery(array $query): self
    {
        $this->data['attributes']['arguments']['query'] = $query;

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function setJsonBody(array $array): self
    {
        return $this->setBody('json', json_encode($array));
    }

    /**
     * @param string $string
     * @return $this
     */
    public function setRawBody(string $string): self
    {
        return $this->setBody('raw', $string);
    }

    /**
     * @param string $type json|raw
     * @param string $body
     * @return $this
     */
    public function setBody(string $type, string $body): self
    {
        $this->data['attributes']['arguments']['body'] = [
            'type' => $type,
            'data' => base64_encode($body),
        ];

        return $this;
    }
}
