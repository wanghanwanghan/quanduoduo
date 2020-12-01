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
            $routeCollector->addRoute(['GET', 'POST'], '/clickLink', $prefix . 'clickLink');
            $routeCollector->addRoute(['GET', 'POST'], '/getOneSaid', $prefix . 'getOneSaid');
            $routeCollector->addRoute(['GET', 'POST'], '/getOneJoke', $prefix . 'getOneJoke');
        });
    }


}
