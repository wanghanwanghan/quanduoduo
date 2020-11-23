<?php

namespace App\HttpService\Common;

use App\HttpService\ServiceBase;
use EasySwoole\Redis\Config\RedisConfig;
use EasySwoole\RedisPool\Redis;

class CreateRedisPool extends ServiceBase
{
    function __construct()
    {
        parent::__construct();
        $this->onServiceCreate();
    }

    private function onServiceCreate()
    {

    }

    function create()
    {
        $conf = new RedisConfig();
        $conf->setHost('127.0.0.1');
        $conf->setPort(56379);
        $conf->setTimeout(5);
        $conf->setAuth('wanghan123');
        $conf->setSerialize(RedisConfig::SERIALIZE_NONE);

        $redisPoolConfig = Redis::getInstance()->register('redis', $conf);
        $redisPoolConfig->setMinObjectNum(10);
        $redisPoolConfig->setMaxObjectNum(20);
        $redisPoolConfig->setAutoPing(10);
    }
}