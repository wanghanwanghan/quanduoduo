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
            $routeCollector->addRoute(['GET', 'POST'], '/addTakeaway', $prefix . 'addTakeaway');
            $routeCollector->addRoute(['GET', 'POST'], '/addVegetable', $prefix . 'addVegetable');
            $routeCollector->addRoute(['GET', 'POST'], '/addSurprise', $prefix . 'addSurprise');
        });
    }


}
