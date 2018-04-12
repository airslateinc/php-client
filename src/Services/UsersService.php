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
