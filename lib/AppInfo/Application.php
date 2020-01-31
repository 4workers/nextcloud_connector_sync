<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\AppInfo;

use OCA\NextcloudConnectorSync\Hook\Files\PreCreate;
use OCP\AppFramework\App;

class Application extends App
{

    public function __construct()
    {
        parent::__construct('nextcloud_connector_sync');
    }

    public function register()
    {
        $container = $this->getContainer();
        $fs = $container->query('ServerContainer')->getUserFolder();
        $fs->listen('\OC\Files', 'preCreate', [PreCreate::class, 'run']);
    }

}
