<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Organization;

use AirSlate\ApiClient\Entities\EntityType;

class Update extends Create
{
    /**
     * Update constructor.
     * @param string $organizationUid
     */
    public function __construct(string $organizationUid)
    {
        parent::__construct();
        $this->data = [
            'id' => $organizationUid,
            'type' => EntityType::ORGANIZATION,
            'attributes' => [],
        ];
    }

    /**
     * @return string
     */
    public function getOrganizationUid(): string
    {
        return $this->data['id'];
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setLogoProfile(string $value): self
    {
        $this->data['attributes']['logo_profile'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setLogoRectangle(string $value): self
    {
        $this->data['attributes']['logo_rectangle'] = $value;

        return $this;
    }
}
