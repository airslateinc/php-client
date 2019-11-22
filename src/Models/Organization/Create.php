<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Organization;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class Create extends AbstractModel
{
    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data = [
            'type' => EntityType::ORGANIZATION,
            'attributes' => [],
        ];
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSubdomain(string $value): self
    {
        $this->data['attributes']['subdomain'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setName(string $value): self
    {
        $this->data['attributes']['name'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCategory(string $value): self
    {
        $this->data['attributes']['category'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSize(string $value): self
    {
        $this->data['attributes']['size'] = $value;

        return $this;
    }
}
