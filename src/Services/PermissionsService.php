<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Permissions\Permission;
use Exception;

/**
 * Class PermissionsService
 *
 * @package AirSlate\ApiClient\Services
 */
class PermissionsService extends AbstractService
{
    /**
     * get all permissions available for current user
     *
     * @param array $permissionCodes filter permissions
     *
     * @return Permission[]
     *
     * @throws Exception
     *
     * @deprecated
     */
    public function userPermissions(array $permissionCodes = null): array
    {
        if ($permissionCodes !== null) {
            $this->addFilter('permission', $permissionCodes);
        }

        $response = $this->httpClient->get($this->resolveEndpoint('/user-permissions'));

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Permission::createFromCollection($content);
    }

    /**
     * check user permission
     *
     * @param string $permissionCode
     *
     * @return bool
     *
     * @throws Exception
     *
     * @deprecated
     */
    public function checkPermission(string $permissionCode): bool
    {
        return $this->checkPermissions([$permissionCode]);
    }

    /**
     * check any user permission
     *
     * @param array $permissionCodes
     *
     * @return bool
     *
     * @throws Exception
     *
     * @deprecated
     */
    public function checkPermissions(array $permissionCodes): bool
    {
        $permissions = $this->userPermissions($permissionCodes);

        return !empty($permissions);
    }

    /**
     * get all permissions available for current user
     *
     * @param array $permissionCodes filter permissions
     *
     * @return Permission[]
     *
     * @throws Exception
     */
    public function getUserPermissions(array $permissionCodes = null): array
    {
        if ($permissionCodes !== null) {
            $this->addFilter('permission', $permissionCodes);
        }

        $response = $this->httpClient->get($this->resolveEndpoint('/team-management/user-permissions'));

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Permission::createFromCollection($content);
    }

    /**
     * check user permission
     *
     * @param string $permissionCode
     *
     * @return bool
     *
     * @throws Exception
     */

    public function checkUserPermission(string $permissionCode): bool
    {
        return $this->checkUserPermissions([$permissionCode]);
    }

    /**
     * check any user permission
     *
     * @param array $permissionCodes
     *
     * @return bool
     *
     * @throws Exception
     */
    public function checkUserPermissions(array $permissionCodes): bool
    {
        $permissions = $this->getUserPermissions($permissionCodes);

        return !empty($permissions);
    }
}
