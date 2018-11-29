<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Services;

use AirSlate\ApiClient\Entities\Permission;

/**
 * Class PermissionsService
 * @package AirSlate\ApiClient\Services
 */
class PermissionsService extends AbstractService
{
    /**
     * get all permissions available for current user
     *
     * @param array $permissionCodes filter permissions
     * @return Permission[]
     * @throws \Exception
     */
    public function userPermissions(array $permissionCodes = null): array
    {
        $url = $this->resolveEndpoint('/user-permissions');

        if ($permissionCodes !== null) {
            $url .= '?' . http_build_query(['filter[permission]' => join(',', $permissionCodes)]);
        }

        $response = $this->httpClient->get($url);

        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return Permission::createFromCollection($content);
    }

    /**
     * check user permission
     *
     * @param string $permissionCode
     * @return bool
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
     * @return bool
     * @throws \Exception
     */
    public function checkPermissions(array $permissionCodes): bool
    {
        $permissions = $this->userPermissions($permissionCodes);

        return !empty($permissions);
    }
}
