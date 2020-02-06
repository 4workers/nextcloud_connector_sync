<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Event\Files;

use OCA\NextcloudConnectorSync\Event\General as GeneralEvent;
use OCA\NextcloudConnectorSync\ProjectStorage;
use OCP\Files\Node;

class PreCreate extends GeneralEvent
{

    public static function create(Node $node, ProjectStorage $storage)
    {
        $projectNode = $storage->projectByNode($node);
        if (!$projectNode) {
            return new static('', []);
        }
        return new static('nodeAdded', [
            'path' => $node->getPath(),
        ]);
    }
}