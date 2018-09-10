<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\EventBus\Event;
use AirSlate\ApiClient\Entities\Token;
use AirSlate\ApiClient\Entities\EventBus\Webhook;
use GuzzleHttp\RequestOptions;

class EventBusService extends AbstractService
{
    const PATH_PREFIX = '/event-bus';
    const PATH_WEBHOOKS = '/webhooks';
    const PATH_EVENTS = '/events';

    /**
     * Get access token for addon
     *
     * @param string $clientId
     * @param string $clientSecret
     * @return Token
     */
    public function getAccessToken(
        string $clientId,
        string $clientSecret
    )
    {
        $url = $this->resolveEndpoint(self::PATH_PREFIX . '/oauth/token');

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
}
