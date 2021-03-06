<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Tests\Unit\Event;

use OCA\NextcloudConnectorSync\Event\Files\PreCreate;
use OCA\NextcloudConnectorSync\ProjectStorage;
use OCA\NextcloudConnectorSync\Tests\TestCase;
use OCP\Files\Node;

class PreCreateTest extends TestCase
{

    public function testCreateForNodeOutsideOfProject()
    {

        $node = $this->createTestNode(Node::class, '/parent/node');
        $propertiesStorage = $this->createPropertiesStorage($node);

        $storage = new ProjectStorage($propertiesStorage);

        $event = PreCreate::create($node, $storage);

        $this->assertEquals('', $event->type());
    }

    public function testCreateForNodeInsideOfProject()
    {

        $node = $this->createTestNode(Node::class, '/project/node');
        $propertiesStorage = $this->createPropertiesStorage($node);

        $storage = new ProjectStorage($propertiesStorage);

        $event = PreCreate::create($node, $storage);

        $this->assertEquals('nodeAdd', $event->type());
        $this->assertEquals(['path' => '/project/node'], $event->params());
    }

}