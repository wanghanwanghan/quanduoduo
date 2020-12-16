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
            $routeCollector->addRoute(['GET', 'POST'], '/deleteLink', $prefix . 'deleteLink');
            $routeCollector->addRoute(['GET', 'POST'], '/editLink', $prefix . 'editLink');
            $routeCollector->addRoute(['GET', 'POST'], '/selectLink', $prefix . 'selectLink');
        });

        $router->addGroup('/msg', function (RouteCollector $routeCollector) {
            $prefix = '/Admin/MsgController/';
            $routeCollector->addRoute(['GET', 'POST'], '/push', $prefix . 'push');
        });

        $router->addGroup('/user', function (RouteCollector $routeCollector) {
            $prefix = '/Admin/UserController/';
            $routeCollector->addRoute(['GET', 'POST'], '/login', $prefix . 'login');
            $routeCollector->addRoute(['GET', 'POST'], '/getMiniAppUserInfo', $prefix . 'getMiniAppUserInfo');
        });

        $router->addGroup('/sys', function (RouteCollector $routeCollector) {
            $prefix = '/Admin/SysController/';
            $routeCollector->addRoute(['GET', 'POST'], '/getMiniAppAccessRecord', $prefix . 'getMiniAppAccessRecord');
        });
    }


}
