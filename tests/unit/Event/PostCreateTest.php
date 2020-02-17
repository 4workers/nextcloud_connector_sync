<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Tests\Unit\Event;

use OCA\NextcloudConnectorSync\Event\Files\PostCreate;
use OCA\NextcloudConnectorSync\ProjectStorage;
use OCA\NextcloudConnectorSync\Tests\TestCase;
use OCP\Files\Node;

class PostCreateTest extends TestCase
{

    public function testCreateForNodeOutsideOfProject()
    {

        $node = $this->createTestNode(Node::class, '/parent/node');
        $propertiesStorage = $this->createPropertiesStorage($node);

        $storage = new ProjectStorage($propertiesStorage);

        $event = PostCreate::create($node, $storage);

        $this->assertEquals('', $event->type());
    }

    public function testCreateForNodeInsideOfProject()
    {

        $node = $this->createTestNode(Node::class, '/project/node');
        $propertiesStorage = $this->createPropertiesStorage($node);

        $storage = new ProjectStorage($propertiesStorage);

        $event = PostCreate::create($node, $storage);

        $this->assertEquals('nodeAdded', $event->type());
        $this->assertEquals([
            'user' => 'matchish',
            'id' => null,
            'name' => null,
            'type' => null
        ], $event->params());
    }

}