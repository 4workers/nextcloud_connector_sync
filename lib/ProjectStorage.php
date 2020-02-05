<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync;


use OCP\Files\Node;
use OCP\Files\NotFoundException;

class ProjectStorage
{

    private $propertiesStorage;

    public function __construct(PropertiesStorage $propertiesStorage)
    {
        $this->propertiesStorage = $propertiesStorage;
    }

    public function projectByNode(Node $node): ?Node
    {
        $currentNode = $node;
        while (true) {
            $foreignId = $this->propertiesStorage->foreignId($currentNode);
            if ($foreignId) {
                return $node;
            }
            try {
                $currentNode = $currentNode->getParent();
            } catch (NotFoundException $e) {
                return null;
            }
        }
    }

}