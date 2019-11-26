<?php

declare(strict_types=1);

namespace AirSlate\ApiClientTests\Unit\Entities;

use AirSlate\ApiClient\Entities\Permissions\MetaPermission;
use AirSlate\ApiClient\Entities\Slate;
use PHPUnit\Framework\TestCase;

class SlateEntityTest extends TestCase
{
    public function testShouldEmptyMetaPermissionsExists()
    {
        $flowFixture = $this->loadJsonFixture('flow');
        $flow = Slate::createFromOne($flowFixture);

        $this->assertInstanceOf(MetaPermission::class, $flow->metaPermissions);

        $permissionAttributes = $flow->metaPermissions->getAttributes();
        $this->assertCount(1, $permissionAttributes);
        $this->assertArrayHasKey('id', $permissionAttributes);
    }

    public function testShouldNonEmptyMetaPermissionsExists()
    {
        $flowFixture = $this->loadJsonFixture('flow_with_meta_permissions');
        $flow = Slate::createFromOne($flowFixture);

        $this->assertInstanceOf(MetaPermission::class, $flow->metaPermissions);

        $permissionAttributes = $flow->metaPermissions->getAttributes();
        $this->assertTrue(count($permissionAttributes) > 1);
    }

    private function loadJsonFixture(string $name): array
    {
        return json_decode(file_get_contents(__DIR__ . "/../fixtures/flows/$name.json"), true);
    }
}
