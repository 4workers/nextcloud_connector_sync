<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Tests\Unit\Event\Files;

use OC\Files\Node\Root;
use OCA\NextcloudConnectorSync\Event\Files\PreCreate;
use OCA\NextcloudConnectorSync\ProjectStorage;
use OCA\NextcloudConnectorSync\PropertiesStorage;
use OCP\Files\Node;
use OCP\Files\NotFoundException;

class PreCreateTest extends \Test\TestCase {

	public function testCreateForNodeOutsideOfProject() {

        $node = $this->createTestNode(Node::class, '/parent/node');
        $propertiesStorage = $this->createPropertiesStorage($node);

        $storage = new ProjectStorage($propertiesStorage);

        $event = PreCreate::create($node, $storage);

        $this->assertEquals('', $event->type());
	}

    public function testCreateForNodeInsideOfProject() {

        $node = $this->createTestNode(Node::class, '/project/node');
        $propertiesStorage = $this->createPropertiesStorage($node);

        $storage = new ProjectStorage($propertiesStorage);

        $event = PreCreate::create($node, $storage);

        $this->assertEquals('nodeAdded', $event->type());
        $this->assertEquals(['path' => '/project/node'], $event->params());
    }

    private function createPropertiesStorage($node)
    {
        $storage = $this->getMockBuilder(PropertiesStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $map = [];
        while (true) {
            $foreignId = null;
            $path = $node->getPath();
            if (basename($path) === 'project') {
                $foreignId = 'project';
            }
            $map[] = [$node, $foreignId];
            try {
                $node = $node->getParent();
            } catch (\Exception $e) {
                break;
            }
        }
        $storage->expects($this->any())
            ->method('foreignId')
            ->will($this->returnValueMap($map));
        return $storage;
    }

    private function createTestNode($class, $path) {
	    if ($path === '/') {
            $node = $this->getMockBuilder(Root::class)
                ->disableOriginalConstructor()
                ->getMock();
            $node->expects($this->any())
                ->method('getPath')
                ->will($this->returnValue('/'));
            $node->expects($this->any())
                ->method('getParent')
                ->will($this->throwException(new NotFoundException));
            return $node;
        }
        $node = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        $node->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue($path));

        $parent = $this->createTestNode(Node::class, dirname($path));

        $node->expects($this->any())
            ->method('getParent')
            ->will($this->returnValue($parent));

        return $node;
    }

}


class Results {

    public function fetch()
    {
        return [];
    }

    public function closeCursor()
    {

    }
}