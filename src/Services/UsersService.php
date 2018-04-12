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
     * Return info about authorized user.
     */
    public function me(): User
    {
        $response = $this->httpClient->get('/v1/users/me');

        $content = \GuzzleHttp\json_decode($response->getBody(), true);
        $user = new User();
        $user->setAttributes(array_merge(
            ['id' => $content['data']['id']],
            $content['data']['attributes']
        ));

        return $user;
    }

    /**
     * Invite new users to organization.
     *
     * @param string $organization
     * @param array $emails
     * @return User[]
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
        $users = [];
        foreach ($content['data'] as $item) {
            $user = new User();
            $user->setAttributes(array_merge(
                ['id' => $item['id']],
                $item['attributes']
            ));
            $users[] = $user;
        }

        return $users;
    }
}
