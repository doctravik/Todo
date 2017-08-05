<?php

return [
    'database' => [
        'connection' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'todo_beejee',
        'user' => 'root',
        'password' => 'test',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],

    'routes' => 'app/routes.php'
];