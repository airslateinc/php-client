<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Token;
use AirSlate\ApiClient\Entities\User;
use GuzzleHttp\RequestOptions;

/**
 * Class UsersService
 * @package AirSlate\UsersManagement\Services
 */
class UsersService extends AbstractService
{
    /**
     * Return info about authorized user.
     * @throws \Exception
     */
    public function me(): User
    {
        $url = $this->resolveEndpoint('/users/me');

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return User::createFromOne($content);
    }

    /**
     * @param string $organizationId
     * @param string $userId
     * @return User
     * @throws \Exception
     */
    public function one(string $organizationId, string $userId): User
    {
        $response = $this->httpClient->get('/v1/organizations/' . $organizationId . '/users/' . $userId);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return User::createFromOne($content);
    }

    /**
     * @param string $organizationId
     * @return User[]
     * @throws \Exception
     */
    public function all(string $organizationId): array
    {
        $response = $this->httpClient->get('/v1/organizations/' . $organizationId . '/users');

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return User::createFromCollection($content);
    }

    /**
     * Invite new users to organization.
     *
     * @param string $organization
     * @param array $emails
     * @return User[]
     * @throws \Exception
     */
    public function invite(string $organization, array $emails): array
    {
        $url = $this->resolveEndpoint('/organizations/' . $organization . '/users/invite');

        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => [
                'data' => [
                    'type' => 'users',
                    'attributes' => [
                        'emails' => $emails
                    ]
                ]
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return User::createFromCollection($content);
    }

    /**
     * @param string $email
     * @return Token
     * @throws \Exception
     */
    public function emailLogin(string $email): Token
    {
        $response = $this->httpClient->post('/v1/auth/email-login', [
            RequestOptions::JSON => [
                'email' => $email
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Token::createFromMeta($content);
    }
}
