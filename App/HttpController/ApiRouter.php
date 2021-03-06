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
            $routeCollector->addRoute(['GET', 'POST'], '/clickGoods', $prefix . 'clickGoods');
            $routeCollector->addRoute(['GET', 'POST'], '/getOneSaid', $prefix . 'getOneSaid');
            $routeCollector->addRoute(['GET', 'POST'], '/getOneJoke', $prefix . 'getOneJoke');
            $routeCollector->addRoute(['GET', 'POST'], '/getHistoryOfToday', $prefix . 'getHistoryOfToday');
            $routeCollector->addRoute(['GET', 'POST'], '/getLifeIndex', $prefix . 'getLifeIndex');
            $routeCollector->addRoute(['GET', 'POST'], '/getConstellation', $prefix . 'getConstellation');
            $routeCollector->addRoute(['GET', 'POST'], '/getOneJokeVideo', $prefix . 'getOneJokeVideo');
        });

        $router->addGroup('/link', function (RouteCollector $routeCollector) {
            $prefix = '/Api/LinkController/';
            $routeCollector->addRoute(['GET', 'POST'], '/selectLink', $prefix . 'selectLink');
        });

        $router->addGroup('/goods', function (RouteCollector $routeCollector) {
            $prefix = '/Api/GoodsController/';
            $routeCollector->addRoute(['GET', 'POST'], '/selectGoods', $prefix . 'selectGoods');
        });
    }


}
