<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\ContentDescriptor;
use PHPUnit\Framework\TestCase;

class ContentDescriptorTest extends TestCase {

    public function testContentDescriptorObject() {
        $id = '1';
        $outputMode = 'raw';
        $pageNumber = '1';
        $permissionVariant = '3';
        $contentDescriptor = new ContentDescriptor();
        self::assertNull($contentDescriptor->getId());
        $contentDescriptor->setId($id);
        self::assertEquals($id, $contentDescriptor->getId());
        self::assertNull($contentDescriptor->getOutputMode());
        $contentDescriptor->setOutputMode($outputMode);
        self::assertEquals($outputMode, $contentDescriptor->getOutputMode());
        self::assertNull($contentDescriptor->getPageNumber());
        $contentDescriptor->setPageNumber($pageNumber);
        self::assertEquals($pageNumber, $contentDescriptor->getPageNumber());
        self::assertNull($contentDescriptor->getPermissionVariant());
        $contentDescriptor->setPermissionVariant($permissionVariant);
        self::assertEquals($permissionVariant, $contentDescriptor->getPermissionVariant());
    }

}
