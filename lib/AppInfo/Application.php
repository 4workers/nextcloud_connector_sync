<?php

declare(strict_types=1);

namespace OCA\NextcloudConnectorSync\AppInfo;

use GuzzleHttp\Client;
use OCA\NextcloudConnectorSync\Connector;
use OCA\NextcloudConnectorSync\Hooks;
use OCA\NextcloudConnectorSync\ProjectStorage;
use OCA\NextcloudConnectorSync\PropertiesStorage;
use OCP\AppFramework\App;
use OCP\EventDispatcher\IEventDispatcher;

class Application extends App
{

    public function __construct()
    {
        parent::__construct('nextcloud_connector_sync');

        $container = $this->getContainer();

        $container->registerService(
            Connector::class, function ($c) {
                return new Connector(new Client(['base_uri' => getenv('WURTH_CONNECTOR_URL')]));
            }
        );

    }

    public function register()
    {
        /* @var IEventDispatcher $eventDispatcher */
        $dispatcher = $this->getContainer()->query(IEventDispatcher::class);
        $dispatcher->addListener('\OCP\Files::postCreate', [Hooks::class, 'postCreateFile']);
    }

}
