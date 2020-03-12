<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\EntityType;
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
    public function organizations(): OrganizationsService
    {
        return new OrganizationsService($this->httpClient);
    }

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
     * @return User
     */
    public function one(string $userId): User
    {
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
     * Invite new users to organization.
     *
     * @param string $organization
     * @param array $emails
     * @param bool|null $sendEmail
     * @return User[]
     */
    public function invite(string $organization, array $emails, bool $sendEmail = null): array
    {
        $url = $this->resolveEndpoint('/organizations/' . $organization . '/users/invite');
        $data = [
            'data' => [
                'type' => EntityType::ORGANIZATION_INVITE,
                'attributes' => [
                    'emails' => $emails
                ]
            ]
        ];
        if ($sendEmail !== null) {
            $data['data']['attributes']['send_invite_email'] = $sendEmail;
        }
        $response = $this->httpClient->post($url, [RequestOptions::JSON => $data]);
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

    public function join(string $orgUid): OrganizationUser
    {
        $url = $this->resolveEndpoint('/organizations/' . $orgUid . '/join');
        $response = $this->httpClient->post($url);
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return OrganizationUser::createFromOne($content);
    }
}
