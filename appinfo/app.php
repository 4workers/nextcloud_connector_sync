<?php

use OCA\NextcloudConnectorSync\AppInfo\Application;

$app = \OC::$server->query(Application::class);
$app->register();
