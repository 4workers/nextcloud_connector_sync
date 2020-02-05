<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync;


use OC\HintException;

class Connector
{
    public function send(Event\General $event)
    {
        if ($event->type()) {
            throw new HintException('not implemented');
        }
    }
}