<?php

namespace OCA\NextcloudConnectorSync\Tests\Unit\Events\Files;

use OCA\NextcloudConnectorSync\Events\Files\PreCreate;
use OCP\Files\Node;
use PHPUnit_Framework_TestCase;

class PreCreateTest extends PHPUnit_Framework_TestCase {

	public function testRun() {

        $node = $this->getMockBuilder(Node::class)->getMock();
        $event = PreCreate::fromNode($node);
        $this->assertEquals($event->type(), 'null');
	}

}
