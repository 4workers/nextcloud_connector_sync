<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Connector
{

    private $connection;

    public function __construct(Client $connection)
    {
        $this->connection = $connection;
    }

    public function send(Event\General $event)
    {
        if ($event->type()) {
            $this->connection->request(
                'POST', '', [
                RequestOptions::JSON => $event->toArray()
                ]
            );
        }
    }
}