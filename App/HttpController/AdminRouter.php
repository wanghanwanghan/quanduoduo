<?php

namespace App\HttpController;

use EasySwoole\Component\Singleton;
use FastRoute\RouteCollector;

class AdminRouter
{
    use Singleton;

    function addRouterV1(RouteCollector $router)
    {
        $router->addGroup('/link', function (RouteCollector $routeCollector) {
            $prefix = '/Admin/LinkController/';
            $routeCollector->addRoute(['GET', 'POST'], '/insertLink', $prefix . 'insertLink');
            $routeCollector->addRoute(['GET', 'POST'], '/editLink', $prefix . 'editLink');
            $routeCollector->addRoute(['GET', 'POST'], '/selectLink', $prefix . 'selectLink');
        });
    }


}
