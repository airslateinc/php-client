<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\IntegrationProxy;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class JsonRequest
 *
 * @package AirSlate\ApiClient\Models\IntegrationProxy
 */
class JsonRequest extends AbstractModel
{
    /* we can use only 'json' or 'form-data' type */

    public function __construct(
        string $slateAddonIntegration,
        string $httpMethod,
        string $url,
        ?array $data,
        array $query = [],
        string $type = 'json'
    ) {
        parent::__construct();

        $this->data = [
            'type' => EntityType::INTEGRATION_REQUESTS,
            'attributes' => [
                'http_method' => $httpMethod,
                'action' => $url,
                'arguments' => [
                    'query' => $query
                ]
            ],
            'relationships' => [
                'slate_addon_integration' => [
                    'data' => [
                        'type' => EntityType::SLATE_ADDON_INTEGRATION,
                        'id' => $slateAddonIntegration

                    ]
                ]
            ]
        ];

        $this->addBody($data, $type);
    }

    /**
     * @param array|null $data
     * @param string $type
     * @return $this
     */
    private function addBody(?array $data, string $type): self
    {
        if ($data !== null) {
            $this->data['attributes']['arguments']['body'] = [
                'type' => $type,
                'data' => $data,
            ];
        }

        return $this;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function addSlateAddonIntegrationId(string $id): self
    {
        $this->data['relationships']['slate_addon_integration']['data']['id'] = $id;

        return $this;
    }

    /**
     * @param string $url
     * @param string $httpMethod
     * @return $this
     */
    public function addAttributes(string $url, string $httpMethod): self
    {
        $this->data['attributes']['action'] = $url;
        $this->data['attributes']['http_method'] = $httpMethod;
        return $this;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function addQuery(array $query = []): self
    {
        $this->data['attributes']['arguments']['query'] = $query;

        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type): self
    {
        $this->data['attributes']['type'] = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return ['data' => $this->data];
    }
}
