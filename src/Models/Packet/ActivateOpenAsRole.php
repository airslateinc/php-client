<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Models\AbstractModel;

class ActivateOpenAsRole extends AbstractModel
{
    /** @var string */
    private $roleId = '';

    /** @var string */
    private $revisionId = '';

    /**
     * @param string $roleId
     * @return ActivateOpenAsRole
     */
    public function setRoleId(string $roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * @param string $revisionId
     * @return ActivateOpenAsRole
     */
    public function setRevisionId(string $revisionId): self
    {
        $this->revisionId = $revisionId;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'role_id' => $this->roleId,
                'revision_id' => $this->revisionId,
            ],
        ];
    }
}
