<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\RoleField;

use AirSlate\ApiClient\Entities\Slates\FlowRoleField;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    public function __construct(array $roleFields = [])
    {
        foreach ($roleFields as $roleField) {
            if (!$roleField instanceof FlowRoleField) {
                throw new \InvalidArgumentException(
                    'Invalid type provided for item. Instance of FlowRoleField expected.'
                );
            }
        }

        parent::__construct($roleFields);
    }

    public function toArray(): array
    {
        return [
            'data' => array_map(function (FlowRoleField $roleField) {
                return $roleField->jsonSerialize()['data'];
            }, $this->data),
        ];
    }
}
