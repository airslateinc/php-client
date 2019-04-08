<?php

namespace AirSlate\ApiClient\Models\RoleDocument;

use AirSlate\ApiClient\Entities\Slates\FlowRoleDocuments;
use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    public function __construct(array $data = [])
    {
        foreach ($data as $datum) {
            if (!$datum instanceof FlowRoleDocuments) {
                throw new \InvalidArgumentException(
                    'Invalid type provided for item. Instance of FlowRoleDocuments expected.'
                );
            }
        }

        parent::__construct($data);
    }

    public function toArray(): array
    {
        return [
            'data' => array_map(function (FlowRoleDocuments $roleDocuments) {
                return $roleDocuments->jsonSerialize()['data'];
            }, $this->data),
        ];
    }
}