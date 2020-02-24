<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Event\Files;

use OCA\NextcloudConnectorSync\Event\General as GeneralEvent;
use OCA\Projects\ProjectsStorage;
use OCP\Files\Node;

class PostCreate extends GeneralEvent
{

    public static function create(Node $node, ProjectsStorage $storage)
    {
        $projectNode = $storage->getForeignIdByNodeId($node->getId());
        if (!$projectNode) {
            return new static('', []);
        }
        return new static(
            'nodeAdded', [
            'user' => $node->getOwner()->getUID(),
            'id' => $node->getId(),
            'name' => $node->getName(),
            'type' => $node->getType()
            ]
        );
    }
}