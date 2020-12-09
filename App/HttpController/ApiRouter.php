<?php

namespace App\HttpController;

use EasySwoole\Component\Singleton;
use FastRoute\RouteCollector;

class ApiRouter
{
    use Singleton;

    function addRouterV1(RouteCollector $router)
    {
        $router->addGroup('/user', function (RouteCollector $routeCollector) {
            $prefix = '/Api/UserController/';
            $routeCollector->addRoute(['GET', 'POST'], '/login', $prefix . 'login');
            $routeCollector->addRoute(['GET', 'POST'], '/bindPhone', $prefix . 'bindPhone');
            $routeCollector->addRoute(['GET', 'POST'], '/edit', $prefix . 'edit');
            $routeCollector->addRoute(['GET', 'POST'], '/clickLink', $prefix . 'clickLink');
            $routeCollector->addRoute(['GET', 'POST'], '/getOneSaid', $prefix . 'getOneSaid');
            $routeCollector->addRoute(['GET', 'POST'], '/getOneJoke', $prefix . 'getOneJoke');
        });

        $router->addGroup('/link', function (RouteCollector $routeCollector) {
            $prefix = '/Api/LinkController/';
            $routeCollector->addRoute(['GET', 'POST'], '/selectLink', $prefix . 'selectLink');
        });
    }


}
