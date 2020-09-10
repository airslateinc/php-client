<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\IntegrationProxy;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Create
 *
 * @package AirSlate\ApiClient\Models\IntegrationProxy
 */
class Request extends AbstractModel
{
    public function __construct(array $data = [])
    {
        $data = array_merge_recursive([
            'type' => EntityType::INTEGRATION_REQUESTS,
            'attributes' => [
                'arguments'=>[
                    'query' =>[]
                ]
            ],
            'relationships' => [
                'slate_addon_integration' => [
                    'data' => [
                        'type' => EntityType::SLATE_ADDON_INTEGRATION
                    ]
                ]
            ]
        ], $data);

        parent::__construct($data);
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
     * @param array|null $data
     * @return $this
     */
    public function addBody(string $type, ?array $data): self
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
