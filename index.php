<?php

include_once 'core/Router.php';
include_once 'core/APIRequest.php';
$routes = include_once 'routes.php';

$request = new APIRequest;
$request->decodeHttpRequest();

$router = new Router;
$router->load($routes);
$router->direct($request->getPath(), $request->getMethod());
