<?php

namespace App\HttpController;

use EasySwoole\Component\Singleton;
use FastRoute\RouteCollector;

class AdminRouter
{
    use Singleton;

    function addRouterV1(RouteCollector $router)
    {
        $prefix = '/Admin/LinkController/';

        $router->addGroup('/link', function (RouteCollector $routeCollector) use ($prefix) {
            $routeCollector->addRoute(['GET', 'POST'], '/insertLink', $prefix . 'insertLink');
            $routeCollector->addRoute(['GET', 'POST'], '/deleteLink', $prefix . 'deleteLink');
            $routeCollector->addRoute(['GET', 'POST'], '/editLink', $prefix . 'editLink');
            $routeCollector->addRoute(['GET', 'POST'], '/selectLink', $prefix . 'selectLink');
        });
    }


}
