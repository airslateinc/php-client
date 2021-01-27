<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Experiment;

class TrackEvent
{
    /**
     * @param string $eventName
     * @param array|null $tags
     * @return string[]
     */
    public static function create(string $eventName, ?array $tags): array
    {
        $data = [
            'event_name' => $eventName
        ];

        if (null !== $tags) {
            $data['tags'] = $tags;
        }

        return $data;
    }
}
