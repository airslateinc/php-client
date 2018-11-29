<?php

namespace AirSlate\ApiClient\Models\Slate;

class Update extends Create
{
    /**
     * @return array
     * @throws \Exception
     */
    public function toArray(): array
    {
        if (empty($this->data['name'])) {
            throw new \Exception('You are unable to update slate without "name" attribute.');
        }
        $data = [
            'type' => 'slates',
            'attributes' => [
                'name' => $this->data['name']
            ],
        ];
        if (!empty($this->data['description'])) {
            $data['attributes']['description'] = $this->data['description'];
        }
        return ['data' => $data];
    }
}
