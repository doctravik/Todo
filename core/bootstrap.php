<?php

use Core\{App, Container};

$container = new Container([ 'config' => require_once('config.php') ]);
$app = new App($container);

$app->run();