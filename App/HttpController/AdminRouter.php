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

        $router->addGroup('/goods', function (RouteCollector $routeCollector) {
            $prefix = '/Admin/GoodsController/';
            $routeCollector->addRoute(['GET', 'POST'], '/insertGoods', $prefix . 'insertGoods');
            $routeCollector->addRoute(['GET', 'POST'], '/deleteGoods', $prefix . 'deleteGoods');
            $routeCollector->addRoute(['GET', 'POST'], '/saleGoods', $prefix . 'saleGoods');
            $routeCollector->addRoute(['GET', 'POST'], '/editGoods', $prefix . 'editGoods');
            $routeCollector->addRoute(['GET', 'POST'], '/selectGoods', $prefix . 'selectGoods');
        });

        $router->addGroup('/label', function (RouteCollector $routeCollector) {
            $prefix = '/Admin/LabelController/';
            $routeCollector->addRoute(['GET', 'POST'], '/insertLabel', $prefix . 'insertLabel');
            $routeCollector->addRoute(['GET', 'POST'], '/deleteLabel', $prefix . 'deleteLabel');
            $routeCollector->addRoute(['GET', 'POST'], '/editLabel', $prefix . 'editLabel');
            $routeCollector->addRoute(['GET', 'POST'], '/selectLabel', $prefix . 'selectLabel');
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
