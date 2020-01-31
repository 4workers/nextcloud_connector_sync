<?php

namespace OCA\NextcloudConnectorSync\Tests\Unit\Hook\Files;

use OCP\Files\Node;
use OCA\NextcloudConnectorSync\Hook\Files\PreCreate;
use PHPUnit_Framework_TestCase;

class PreCreateTest extends PHPUnit_Framework_TestCase {

	public function testRun() {

	    $hook = new PreCreate();
        $node = $this->getMockBuilder(Node::class)->getMock();

        $hook->run($node);

	}

}
