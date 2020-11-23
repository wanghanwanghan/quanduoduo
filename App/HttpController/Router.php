<?php

namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\AbstractRouter;
use FastRoute\RouteCollector;

class Router extends AbstractRouter
{
    public function initialize(RouteCollector $routeCollector)
    {
        //全局模式拦截下,路由将只匹配Router.php中的控制器方法响应,将不会执行框架的默认解析
        $this->setGlobalMode(true);

        //前端
        $routeCollector->addGroup('/api/v1',function (RouteCollector $routeCollector)
        {
            ApiRouter::getInstance()->addRouterV1($routeCollector);
        });

        //后台
        $routeCollector->addGroup('/admin/v1',function (RouteCollector $routeCollector)
        {
            AdminRouter::getInstance()->addRouterV1($routeCollector);
        });
    }
}
