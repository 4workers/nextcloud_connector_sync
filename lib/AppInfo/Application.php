<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\AppInfo;

use OCA\NextcloudConnectorSync\Hooks;
use OCA\NextcloudConnectorSync\ProjectStorage;
use OCP\AppFramework\App;
use OCP\IDBConnection;

class Application extends App
{

    public function __construct()
    {
        parent::__construct('nextcloud_connector_sync');

        $container = $this->getContainer();

        $container->registerService(ProjectStorage::class, function($c) {
            return new ProjectStorage($c->query(IDBConnection::class));
        });
    }

    public function register()
    {
        $container = $this->getContainer();
        $server = $container->query('ServerContainer');
        $root = $server->getRootFolder();
        $root->listen('\OC\Files', 'preCreate', [Hooks::class, 'preCreateFile']);
    }

}
