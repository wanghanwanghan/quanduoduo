<?php

namespace App\HttpController;

use EasySwoole\Component\Singleton;
use FastRoute\RouteCollector;

class AdminRouter
{
    use Singleton;

    function addRouterV1(RouteCollector $router)
    {
        $prefix='/Admin/UserController/';

        $router->addGroup('/user',function (RouteCollector $routeCollector) use ($prefix)
        {
            $routeCollector->addRoute(['GET','POST'],'/getThreeYearsData',$prefix.'getThreeYearsData');
        });

        return true;
    }



}
