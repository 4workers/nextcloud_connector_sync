<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync;

use OCA\NextcloudConnectorSync\Event\Files\PostCreate;
use OCA\Projects\ProjectsStorage;
use Throwable;
use OC;
use OC\Files\Node\Node;
use OC\HintException;
use OCA\NextcloudConnectorSync\Event\Files\PreCreate;

class Hooks
{

    public static function postCreateFile($event)
    {
        $subject = $event->getSubject();
        $subject = is_array($subject) ? $subject : [$subject];

        try {
            foreach ($subject as $node) {
                static::sendEventOnPostCreateFile($node);
            }
        } catch (Throwable $e) {
//            We should catch all exceptions and throw uncatchable exception
            throw new HintException($e);
        }
    }


    private static function sendEventOnPostCreateFile(Node $node)
    {
        $projectStorage = OC::$server->query(ProjectsStorage::class);
        $event = PostCreate::create($node, $projectStorage);
        $connector = OC::$server->query(Connector::class);
        $connector->send($event);
    }

}