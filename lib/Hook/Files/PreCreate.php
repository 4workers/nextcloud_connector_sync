<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\Hook\Files;


use OCP\Files\Node;

class PreCreate
{
    public static function run(Node $node)
    {
        throw new \Error('not implemented');
    }
}