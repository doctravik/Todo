<?php

$router->get('/tasks', 'TaskController@index');
$router->post('/tasks', 'TaskController@store');
$router->get('/tasks/{id}/edit', 'Admin\\TaskController@edit');
$router->post('/tasks/{id}', 'Admin\\TaskController@update');

$router->get('/admin', 'Auth\\LoginController@showLoginForm');
$router->post('/admin/login', 'Auth\\LoginController@login');
$router->post('/admin/logout', 'Auth\\LoginController@logout');
