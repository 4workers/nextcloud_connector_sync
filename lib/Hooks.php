<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync;

use Throwable;
use OC;
use OC\Files\Node\Node;
use OC\HintException;
use OCA\NextcloudConnectorSync\Event\Files\PreCreate;

class Hooks
{

    public static function preCreateFile($event)
    {
        $subject = $event->getSubject();
        $subject = is_array($subject) ? $subject : [$subject];

        try {
            foreach ($subject as $node) {
                static::sendEventOnPreCreateFile($node);
            }
        } catch (Throwable $e) {
            //We should catch all exceptions and throw uncatchable exception
            throw new HintException($e);
        }
    }

    public static function postCreateFile($event)
    {
        $subject = $event->getSubject();
        $subject = is_array($subject) ? $subject : [$subject];

        try {
            foreach ($subject as $node) {
                static::sendEventOnPostCreateFile($node);
            }
        } catch (Throwable $e) {
            //We should catch all exceptions and throw uncatchable exception
            throw new HintException($e);
        }
    }

    private static function sendEventOnPreCreateFile(Node $node)
    {
        $projectStorage = OC::$server->query(ProjectStorage::class);
        $event = PreCreate::create($node, $projectStorage);
        $connector = OC::$server->query(Connector::class);
        $connector->send($event);
    }

    private static function sendEventOnPostCreateFile(Node $node)
    {
        $projectStorage = OC::$server->query(ProjectStorage::class);
        $event = PostCreate::create($node, $projectStorage);
        $connector = OC::$server->query(Connector::class);
        $connector->send($event);
    }

}