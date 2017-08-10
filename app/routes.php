<?php

$router->get('/', 'TaskController@index');
$router->get('/tasks', 'TaskController@index');
$router->get('/tasks/create', 'TaskController@create');
$router->post('/tasks', 'TaskController@store');
$router->get('/tasks/{id}/edit', 'TaskController@edit');
$router->post('/tasks/{id}/update', 'TaskController@update');
$router->post('/tasks/{id}/status/update', 'StatusController@update');
$router->post('/tasks/{id}/image/upload', 'ImageController@store');

$router->get('/admin', 'Auth\\LoginController@showLoginForm');
$router->post('/admin/login', 'Auth\\LoginController@login');
$router->post('/admin/logout', 'Auth\\LoginController@logout');
