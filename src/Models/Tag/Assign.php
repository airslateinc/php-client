<?php

namespace AirSlate\ApiClient\Models\Tag;

use AirSlate\ApiClient\Models\AbstractModel;

class Assign extends AbstractModel
{
    public function setNames(array $names)
    {
        $this->data['names'] = $names;
    }

    public function toArray(): array
    {
        $tags = [];

        foreach ($this->data['names'] as $name) {
            $tags[] =  [
                'type' => 'flow_tags',
                'attributes' => [
                    'name' => $name,
                ],
            ];
        }

        return [
            'data' => $tags
        ];
    }
}
