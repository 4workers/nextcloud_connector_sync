<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync;

use OCA\NextcloudConnectorSync\Event\Files\PreCreate;
use OCP\Files\Node;

class Hooks
{

    public static function preCreateFile(Node $node)
    {
        $projectStorage = \OC::$server->query(ProjectStorage::class);
        $event = PreCreate::create($node, $projectStorage);
        $connector = \OC::$server->query(Connector::class);
        $connector->send($event);
    }
}