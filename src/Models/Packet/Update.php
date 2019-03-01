<?php

namespace AirSlate\ApiClient\Models\Packet;

use AirSlate\ApiClient\Models\AbstractModel;

class Update extends AbstractModel
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Update
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * @return array
     * @throws \Exception
     */
    public function toArray(): array
    {
        return [
            'data' => [
                'type' => 'packets',
                'attributes' => [
                    'name' => $this->name
                ]
            ],
        ];
    }
}
