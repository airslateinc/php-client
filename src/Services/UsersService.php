<?php

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\User;
use AirSlate\ApiClient\Http\Client;
use GuzzleHttp\RequestOptions;

/**
 * Class UsersService
 * @package AirSlate\UsersManagement\Services
 */
class UsersService
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * UsersService constructor.
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string|array $include
     * @return UsersService
     * @throws \Exception
     */
    public function with($include): UsersService
    {
        $this->httpClient->with($include);

        return $this;
    }

    /**
     * Return info about authorized user.
     * @throws \Exception
     */
    public function me(): User
    {
        $response = $this->httpClient->get('/v1/users/me');

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
        $response = $this->httpClient->post('/v1/organizations/' . $organization . '/users/invite', [
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
}
