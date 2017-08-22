<?php

use Core\{App, Container};

$container = Container::instance();
$container->init([ 'config' => require_once('config.php') ]);
$app = new App($container);

$app->run();
