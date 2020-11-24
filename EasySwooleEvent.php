<?php

namespace EasySwoole\EasySwoole;

use App\HttpService\Common\CreateMysqlOrm;
use App\HttpService\Common\CreateMysqlPool;
use App\HttpService\Common\CreateRedisPool;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;

class EasySwooleEvent implements Event
{
    public static function initialize()
    {
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
        define('STATIC_PATH', ROOT_PATH . 'Static' . DIRECTORY_SEPARATOR);
        define('FILE_PATH', STATIC_PATH . 'File' . DIRECTORY_SEPARATOR);

        CreateRedisPool::getInstance()->create();
        CreateMysqlPool::getInstance()->create();
        CreateMysqlOrm::getInstance()->create();
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        $response->withHeader('Access-Control-Allow-Origin', '*');
        $response->withHeader('Access-Control-Allow-Methods', 'GET, POST');
        $response->withHeader('Access-Control-Allow-Credentials', 'true');
        $response->withHeader('Access-Control-Allow-Headers', '*');
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
    }
}