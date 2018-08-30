<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Organization;
use AirSlate\ApiClient\Entities\Token;
use AirSlate\ApiClient\Entities\User;
use GuzzleHttp\RequestOptions;

/**
 * Class UsersService
 * @package AirSlate\ApiClient\Services
 */
class UsersService extends AbstractService
{
    /**
     * @param string $organizationId
     * @return Organization
     * @throws \Exception
     */
    public function organization(string $organizationId): Organization
    {
        $url = $this->resolveEndpoint('/organizations/' . $organizationId);
        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Organization::createFromOne($content);
    }

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
        $url = $this->resolveEndpoint('/organizations/' . $organizationId . '/users/' . $userId);
        $response = $this->httpClient->get($url);

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
        $url = $this->resolveEndpoint('/organizations/' . $organizationId . '/users');
        $response = $this->httpClient->get($url);

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
     * @deprecated will be removed in new version
     */
    public function emailLogin(string $email): Token
    {
        $url = $this->resolveEndpoint('/auth/email-login');
        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => [
                'email' => $email
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Token::createFromMeta($content);
    }

    /**
     * @param string $email
     * @return User
     * @throws \Exception
     */
    public function simplifiedRegister(string $email): User
    {
        $url = $this->resolveEndpoint('/auth/simplified-register');
        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => [
                'email' => $email
            ]
        ]);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return User::createFromOne($content);
    }
}
