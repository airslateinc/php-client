<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Organization;
use AirSlate\ApiClient\Entities\OrganizationUser;
use AirSlate\ApiClient\Entities\User;
use GuzzleHttp\Exception\ClientException;
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
     * Return one user.
     *
     * @param string $userId
     * @param null|string $deprecatedUserId for back compatibility
     * @return User
     * @throws \Exception
     */
    public function one(string $userId, ?string $deprecatedUserId = null): User
    {
        if ($deprecatedUserId !== null) {
            $userId = $deprecatedUserId;
        }
        $url = $this->resolveEndpoint('/users/' . $userId);
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
     * Fetch organization users by organization id
     *
     * @param string $organizationId
     * @return array
     * @throws \Exception
     */
    public function organizationUsers(string $organizationId): array
    {
        $url = $this->resolveEndpoint('/organizations/' . $organizationId . '/organization-users');
        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return OrganizationUser::createFromCollection($content);
    }

    /**
     * Fetch organization users by organization and user
     *
     * @param string $organizationUid
     * @param string $userUid
     * @return array
     * @throws \Exception
     */
    public function organizationUser(string $organizationUid, string $userUid): array
    {
        $url = $this->resolveEndpoint('/organization-users');
        $this->httpClient->addFilter('organization', $organizationUid);
        $this->httpClient->addFilter('user', $userUid);

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return OrganizationUser::createFromCollection($content);
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
     * Check whether the user exists
     * @throws \Exception
     */
    public function exists(): bool
    {
        $url = $this->resolveEndpoint('/users/exists');

        try {
            $response = $this->httpClient->get($url);
        } catch (ClientException $e) {
            return false;
        }

        return $response && $response->getStatusCode() === 204;
    }
}
