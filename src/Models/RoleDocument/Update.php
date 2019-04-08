<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\RoleDocument;

use AirSlate\ApiClient\Entities\Slates\RoleDocuments;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    public function __construct(array $roleDocuments = [])
    {
        foreach ($roleDocuments as $roleDocument) {
            if (!$roleDocument instanceof RoleDocuments) {
                throw new \InvalidArgumentException(
                    'Invalid type provided for item. Instance of FlowRoleDocuments expected.'
                );
            }
        }

        parent::__construct($roleDocuments);
    }

    public function toArray(): array
    {
        return [
            'data' => array_map(function (RoleDocuments $roleDocuments) {
                return $roleDocuments->jsonSerialize()['data'];
            }, $this->data),
        ];
    }
}
