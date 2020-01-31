<?php

namespace OCA\NextcloudConnectorSync\Tests\Unit\Event\Files;

use OCA\NextcloudConnectorSync\Event\Files\PreCreate;
use OCP\Files\Node;
use PHPUnit_Framework_TestCase;

class PreCreateTest extends PHPUnit_Framework_TestCase {

	public function testFromNotRootNode() {

        $parent = $this->getMockBuilder(Node::class)
            ->getMock();
        $node = $this->getMockBuilder(Node::class)
            ->getMock();
        $node
            ->expects($this->once())
            ->method('getParent')
            ->will($this->returnValue($parent));

        $event = PreCreate::fromNode($node);

        $this->assertEquals('null', $event->type());
	}

}
