<?php

declare(strict_types=1);

namespace AirSlate\ApiClient\Entities\Permissions;

use AirSlate\ApiClient\Entities\BaseEntity;
use AirSlate\ApiClient\Entities\EntityType;

/**
 * @package AirSlate\ApiClient\Entities\Permissions
 *
 * @property string $id
 * @property bool $view_flow
 * @property bool $manage_flow
 * @property bool $manage_flow_addons
 * @property bool $manage_flow_roles
 * @property bool $hide_flow
 * @property bool $join_flow
 * @property bool $leave_flow
 * @property bool $copy_flow
 * @property bool $archive_flow
 * @property bool $restore_archived_flow
 * @property bool $view_audit_trail
 * @property bool $view_bots_log
 * @property bool $distribute_flow
 * @property bool $distribute_flow_team
 * @property bool $distribute_flow_public_link
 * @property bool $distribute_flow_invites
 * @property bool $distribute_flow_redirect
 * @property bool $create_slates
 * @property bool $send_slates_bulk
 * @property bool $export_slates
 * @property bool $can_delete_flow
 */
class MetaPermission extends BaseEntity
{
    /**
     * @var string
     */
    protected $type = EntityType::META_PERMISSION;
}
