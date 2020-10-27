<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Experiment\Experiment;
use AirSlate\ApiClient\Models\Experiment\RunExperiment;
use GuzzleHttp\RequestOptions;

class ExperimentsService extends AbstractService
{
    public function run(string $experimentUid): Experiment
    {
        $url = $this->resolveEndpoint("/experiments/run");

        $response = $this->httpClient->post(
            $url,
            [
                RequestOptions::JSON => RunExperiment::create($experimentUid)->toArray()
            ]
        );

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Experiment::createFromOne($content);
    }

    /**
     * @param string $experimentUid
     * @return bool
     * @throws \Exception
     */
    public function runSimpleExperiment(string $experimentUid): bool
    {
        return $this->run($experimentUid)->getBranch()->version > 1;
    }
}
