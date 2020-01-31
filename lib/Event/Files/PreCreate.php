<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Event\Files;


use OCA\NextcloudConnectorSync\Event\General as GeneralEvent;
use OCP\Files\Node;

class PreCreate extends GeneralEvent
{

    public static function fromNode(Node $node)
    {
        $parent = $node->getParent();
        if ($parent) {
            return new static('null', []);
        }
        return new static('beforeCreate', []);
    }
}