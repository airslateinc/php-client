<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Permissions\Permission;

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
     * @return \AirSlate\ApiClient\Entities\Permissions\Permission[]
     *
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
     */
    public function checkPermissions(array $permissionCodes): bool
    {
        $permissions = $this->userPermissions($permissionCodes);

        return !empty($permissions);
    }
}
