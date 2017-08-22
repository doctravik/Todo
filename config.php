<?php

return [
    'database' => [
        'connection' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'todo_beejee',
        'user' => 'root',
        'password' => 'test',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    ],
    'image' => [
        'upload' => 'app/public/images'
    ],

    'routes' => 'app/routes.php',
];
