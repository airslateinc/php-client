<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\EntityType;
use AirSlate\ApiClient\Entities\Organization;
use AirSlate\ApiClient\Entities\OrganizationUser;
use AirSlate\ApiClient\Entities\ParticipantRole;
use AirSlate\ApiClient\Entities\Token;
use AirSlate\ApiClient\Entities\User;
use AirSlate\ApiClient\Exceptions\DomainException;
use AirSlate\ApiClient\Exceptions\Users\UnauthorizedClient;
use BadMethodCallException;
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
     * @param string $email
     * @param string $password
     * @param string $clientToken
     * @return Token
     * @throws UnauthorizedClient
     *
     * @see UsersService::authenticate() to get client token
     */
    public function signIn(string $email, string $password, string $clientToken): Token
    {
        $url = $this->resolveEndpoint('/auth/sign-in');

        $this->authToken($clientToken);
        try {
            $response = $this->httpClient->post(
                $url,
                [
                    RequestOptions::JSON => [
                        'username' => $email,
                        'password' => $password,
                    ]
                ]
            );

            $content = \GuzzleHttp\json_decode($response->getBody(), true);
        } catch (DomainException $exception) {
            if ($exception->getCode() === 401) {
                throw new UnauthorizedClient();
            }

            throw $exception;
        }

        return Token::createFromMeta($content);
    }

    /**
     * @return Token
     * @throws BadMethodCallException
     */
    public function authenticate(): Token
    {
        $url = $this->resolveEndpoint('/auth/token');

        $clientId = $this->httpClient->getClientId();
        $clientSecret = $this->httpClient->getClientSecret();

        if (empty($clientId) || empty($clientSecret)) {
            throw new BadMethodCallException('Client credentials attributes are required');
        }

        $response = $this->httpClient->post(
            $url,
            [
                RequestOptions::JSON => [
                    'meta' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                    ],
                ]
            ]
        );
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Token::createFromMeta($content);
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
     * @return User[]
     * @throws \Exception
     */
    public function invite(string $organization, array $emails): array
    {
        $url = $this->resolveEndpoint('/organizations/' . $organization . '/users/invite');
        $response = $this->httpClient->post(
            $url,
            [
                RequestOptions::JSON => [
                    'data' => [
                        'type' => EntityType::USER,
                        'attributes' => [
                            'emails' => $emails
                        ]
                    ]
                ]
            ]
        );

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

    /**
     * auth required
     * @return ParticipantRole[]
     */
    public function getParticipantRoles(): array
    {
        $url = $this->resolveEndpoint('/participant-roles');
        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return ParticipantRole::createFromCollection($content);
    }

    public function assignParticipantRoles(
        string $userOrganizationUid,
        string ...$participantRolesUids
    ): void {
        $data = [];
        foreach ($participantRolesUids as $uid) {
            $data[] = [
                'type' => EntityType::PARTICIPANT_ROLES,
                'id' => $uid,
            ];
        }
        $url = $this->resolveEndpoint("/organization-users/{$userOrganizationUid}/roles");
        $this->httpClient->patch(
            $url,
            [
                RequestOptions::JSON => ['data' => $data]
            ]
        );
    }

    public function changeOrganizationOwner(string $organizationUid, string $userUid): void
    {
        $url = $this->resolveEndpoint("/organizations/{$organizationUid}/relationships/owner");
        $this->httpClient->patch(
            $url,
            [
                RequestOptions::JSON => [
                    'data' => [
                        'type' => EntityType::USER,
                        'id' => $userUid
                    ]
                ]
            ]
        );
    }
}
