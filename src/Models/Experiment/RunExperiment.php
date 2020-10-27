<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Models\Experiment;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Models\AbstractModel;

class RunExperiment extends AbstractModel
{
    public static function create(string $experimentUid): self
    {
        return new RunExperiment(
            [
                'type' => EntityType::EXPERIMENT,
                'attributes' => [
                    'experiment_uid' => $experimentUid,
                ]
            ]
        );
    }
}
