<?php

class Router
{
    protected $routes;

    function load($routes)
    {
        $this->routes = $routes;
    }

    function direct($path, $method)
    {
        if (array_key_exists($path, $this->routes[$method])) {
            require $this->routes[$method][$path];
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Route inesistente."));
        }
    }
}
