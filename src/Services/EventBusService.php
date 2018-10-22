<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\EventBus\Event;
use AirSlate\ApiClient\Entities\Token;
use AirSlate\ApiClient\Entities\EventBus\Webhook;
use AirSlate\ApiClient\Http\Client as HttpClient;
use GuzzleHttp\RequestOptions;

class EventBusService extends AbstractService
{
    const PATH_PREFIX = '/event-bus';
    const PATH_WEBHOOKS = '/webhooks';
    const PATH_EVENTS = '/events';
    const PATH_TOKEN = '/oauth/token';
    private const ENDPOINT_METRICS_ACTIVE_USERS = '/audit-trail/metrics/organizations/{organizationId}/active-users';

    /**
     * Get access token for event-bus service
     *
     * @param string $clientId
     * @param string $clientSecret
     * @return Token
     */
    protected function getAccessToken(
        string $clientId,
        string $clientSecret
    ) {
        $url = $this->resolveEndpoint(self::PATH_PREFIX . self::PATH_TOKEN);

        $response = $this->httpClient->post($url, [
            RequestOptions::FORM_PARAMS => [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);
        $accessToken = Token::createFromMeta(['meta' => $content]);

        return $accessToken;
    }

    public function authorize(string $clientId, string $clientSecret): self
    {
        $token = $this->getAccessToken($clientId, $clientSecret);
        $config = $this->httpClient->getConfig();
        $config['headers']['Authorization'] = "Bearer {$token->getAccessToken()}";

        $client = new HttpClient($config);
        $this->setClient($client);

        return $this;
    }

    public function pushEvent(Event $event): Event
    {
        $url = $this->resolveEndpoint(self::PATH_PREFIX . self::PATH_EVENTS);

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $event->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Event::createFromOne($content);
    }

    public function createWebhook(Webhook $webhook): Webhook
    {
        $url = $this->resolveEndpoint(self::PATH_PREFIX . self::PATH_WEBHOOKS);

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $webhook->toArray(),
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Webhook::createFromOne($content);
    }

    /**
     * @param string $webhookId
     * @return Webhook
     * @throws \Exception
     */
    public function getWebhook(string $webhookId)
    {
        $url = $this->resolveEndpoint(self::PATH_PREFIX . self::PATH_WEBHOOKS . '/' . $webhookId);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Webhook::createFromOne($content);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getWebhooksCollection()
    {
        $url = $this->resolveEndpoint(self::PATH_PREFIX . self::PATH_WEBHOOKS);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Webhook::createFromCollection($content);
    }

    /**
     * @param string $webhookId
     * @return bool
     */
    public function deleteWebhook(string $webhookId): bool
    {
        $url = $this->resolveEndpoint(self::PATH_PREFIX . self::PATH_WEBHOOKS . '/' . $webhookId);

        $response = $this->httpClient->delete($url);

        return $response && $response->getStatusCode() === 204;
    }

    /**
     * @param string $organizationId
     * @param \DateTime|null $dateFrom
     * @param \DateTime|null $dateTo
     * @param int $activities
     * @return int
     */
    public function getActiveUsersCountForPeriod(
        string $organizationId,
        \DateTime $dateFrom = null,
        \DateTime $dateTo = null,
        int $activities = 1
    ): int {
        if ($dateFrom instanceof \DateTime) {
            $this->addFilter('date_from', $dateFrom->format('Y-m-d H:i:s'));
        }

        if ($dateTo instanceof \DateTime) {
            $this->addFilter('date_to', $dateTo->format('Y-m-d H:i:s'));
        }

        $this->addFilter('activities', $activities);

        $url = $this->resolveEndpoint(self::PATH_PREFIX . self::ENDPOINT_METRICS_ACTIVE_USERS);
        $response = $this->httpClient->get(
            \strtr(
                $url,
                ['{organizationId}' => $organizationId]
            )
        );
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return $content['meta']['active_users'];
    }
}
