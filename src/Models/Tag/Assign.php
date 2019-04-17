<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Tag;

use AirSlate\ApiClient\Models\AbstractModel;

/**
 * Class Assign
 * @package AirSlate\ApiClient\Models\Tag
 */
class Assign extends AbstractModel
{
    /**
     * @param array $names
     */
    public function setNames(array $names)
    {
        $this->data['names'] = $names;
    }

    /**
     * @return array
     */
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
