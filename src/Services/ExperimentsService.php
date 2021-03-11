<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Experiment\Experiment;
use AirSlate\ApiClient\Models\Experiment\RunExperiment;
use AirSlate\ApiClient\Models\Experiment\TrackEvent;
use GuzzleHttp\RequestOptions;

class ExperimentsService extends AbstractService
{
    public function run(string $experimentUid): Experiment
    {
        $url = $this->resolveEndpoint("/experiments/$experimentUid");

        $response = $this->httpClient->get($url);

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

    /**
     * @param string $eventName
     * @param array|null $tags
     */
    public function track(string $eventName, ?array $tags): void
    {
        $url = $this->resolveEndpoint('/experiments/track');

        $this->httpClient->get(
            $url,
            [
                RequestOptions::JSON => TrackEvent::create($eventName, $tags)
            ]
        );
    }
}
