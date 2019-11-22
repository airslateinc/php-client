<?php

declare(strict_types=1);

namespace AirSlate\ApiClientTests\Unit\Entities;

use AirSlate\ApiClient\Entities\Permissions\MetaPermission;
use AirSlate\ApiClient\Entities\Slate;
use PHPUnit\Framework\TestCase;

class MetaPermissionEntityTest extends TestCase
{
    public function testShouldNonEmptyMetaPermissionsExists()
    {
        $flowFixture = $this->loadJsonFixture('flow_with_meta_permissions');
        $flow = Slate::createFromOne($flowFixture);
        $metaPermissions = $flow->metaPermissions;

        $this->assertIsBool($metaPermissions->view_flow);
        $this->assertIsBool($metaPermissions->manage_flow);
        $this->assertIsBool($metaPermissions->manage_flow_addons);
        $this->assertIsBool($metaPermissions->manage_flow_roles);
        $this->assertIsBool($metaPermissions->hide_flow);
        $this->assertIsBool($metaPermissions->join_flow);
        $this->assertIsBool($metaPermissions->leave_flow);
        $this->assertIsBool($metaPermissions->copy_flow);
        $this->assertIsBool($metaPermissions->archive_flow);
        $this->assertIsBool($metaPermissions->restore_archived_flow);
        $this->assertIsBool($metaPermissions->view_audit_trail);
        $this->assertIsBool($metaPermissions->view_bots_log);
        $this->assertIsBool($metaPermissions->distribute_flow);
        $this->assertIsBool($metaPermissions->distribute_flow_team);
        $this->assertIsBool($metaPermissions->distribute_flow_public_link);
        $this->assertIsBool($metaPermissions->distribute_flow_invites);
        $this->assertIsBool($metaPermissions->distribute_flow_redirect);
        $this->assertIsBool($metaPermissions->create_slates);
        $this->assertIsBool($metaPermissions->send_slates_bulk);
        $this->assertIsBool($metaPermissions->export_slates);
        $this->assertIsBool($metaPermissions->can_delete_flow);
    }

    private function loadJsonFixture(string $name): array
    {
        return json_decode(file_get_contents(__DIR__ . "/../fixtures/flows/$name.json"), true);
    }
}
