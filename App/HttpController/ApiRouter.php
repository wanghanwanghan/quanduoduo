<?php

namespace App\HttpController;

use EasySwoole\Component\Singleton;
use FastRoute\RouteCollector;

class ApiRouter
{
    use Singleton;

    function addRouterV1(RouteCollector $router)
    {
        $prefix = '/Api/UserController/';

        $router->addGroup('/user', function (RouteCollector $routeCollector) use ($prefix) {
            $routeCollector->addRoute(['GET', 'POST'], '/hkf', $prefix . 'hkf');
            $routeCollector->addRoute(['GET', 'POST'], '/login', $prefix . 'login');
        });
    }


}
