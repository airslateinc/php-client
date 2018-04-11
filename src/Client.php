<?php

namespace AirSlate\UsersManagement;

use AirSlate\UsersManagement\Entities\User;
use AirSlate\UsersManagement\Http\Client as HttpClient;
use GuzzleHttp\RequestOptions;

/**
 * Class Client
 * @package AirSlate\UsersManagement
 */
class Client
{
    /**
     *
     */
    const LATEST_API_VERSION = 1;

    /**
     * Client instances.
     * @var Client
     */
    static private $instance;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Client constructor.
     * @param string $baseUri
     * @param array $config
     */
    private function __construct(string $baseUri, $config = [])
    {
        $this->httpClient = new HttpClient([
            'base_uri' => $baseUri,
            'headers' => [
                'Authorization' => 'Bearer ' . $config['token']
            ]
        ]);
    }

    /**
     * @param string $baseUri
     * @param array $config
     * @return Client
     */
    public static function getInstance(string $baseUri, $config = [])
    {
        if (!self::$instance) {
            self::$instance = new self($baseUri, $config);
        }

        return self::$instance;
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
