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

        CreateMysqlOrm::getInstance()->create();
    }

    public static function mainServerCreate(EventRegister $register)
    {
        CreateRedisPool::getInstance()->create();
        CreateMysqlPool::getInstance()->create();
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
    }
}