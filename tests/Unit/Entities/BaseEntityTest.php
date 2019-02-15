<?php

namespace AirSlate\ApiClientTests\Unit\Entities;

use AirSlate\ApiClient\Entities\Document;
use PHPUnit\Framework\TestCase;

class BaseEntityTest extends TestCase
{
    public function testShouldAssignIncludesForCollection()
    {
        $documentsFixture = $this->loadJsonFixture('documents_collection');
        $documents = Document::createFromCollection($documentsFixture);

        $this->assertCount(2, $documents[0]->getIncluded());
    }

    public function testShouldAssingIncludesForEntity()
    {
        $documentsFixture = $this->loadJsonFixture('document');
        $document = Document::createFromOne($documentsFixture);

        $this->assertCount(2, $document->getIncluded());
    }

    private function loadJsonFixture(string $name): array
    {
        return json_decode(file_get_contents(__DIR__ . "/../fixtures/documents/$name.json"), true);
    }
}
