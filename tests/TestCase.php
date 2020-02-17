<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Tests;


use OCP\Files\Node;
use Exception;
use OC\Files\Node\Root;
use OCA\NextcloudConnectorSync\PropertiesStorage;
use OCP\Files\NotFoundException;
use OCP\IUser;

class TestCase extends \Test\TestCase
{
    protected function createTestNode($class, $path)
    {
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

        $user = $this->getMockBuilder(IUser::class)
            ->disableOriginalConstructor()
            ->getMock();

        $user->expects($this->any())
            ->method('getUID')
            ->will($this->returnValue('matchish'));

        $node = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        $node->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue($path));

        $node->expects($this->any())
            ->method('getOwner')
            ->will($this->returnValue($user));

        if (basename($path) === 'project') {
            $node->expects($this->any())
                ->method('getId')
                ->will($this->returnValue('11'));
            $node->expects($this->any())
                ->method('getType')
                ->will($this->returnValue('dir'));
            $node->expects($this->any())
                ->method('getName')
                ->will($this->returnValue('project-1'));
        }

        $parent = $this->createTestNode(Node::class, dirname($path));

        $node->expects($this->any())
            ->method('getParent')
            ->will($this->returnValue($parent));

        return $node;
    }

    protected function createPropertiesStorage($node)
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
            } catch (Exception $e) {
                break;
            }
        }
        $storage->expects($this->any())
            ->method('foreignId')
            ->will($this->returnValueMap($map));
        return $storage;
    }

}