<?php

namespace App\HttpService\Common;

use EasySwoole\Component\Singleton;
use EasySwoole\Mysqli\Client;
use EasySwoole\Mysqli\Config;
use EasySwoole\Pool\AbstractPool;
use EasySwoole\Pool\Manager;

class CreateMysqlPool extends AbstractPool
{
    use Singleton;

    private $mysqlConf;

    function __construct()
    {
        parent::__construct(new \EasySwoole\Pool\Config());

        $mysqlConf = new Config([
            'host' => '127.0.0.1',
            'port' => 63306,
            'user' => 'chinaiiss',
            'password' => 'zbxlbj@2018*()',
            'database' => 'quanduoduo',
            'timeout' => 5,
            'charset' => 'utf8mb4',
        ]);

        $this->mysqlConf = $mysqlConf;
    }

    protected function createObject()
    {
        return new Client($this->mysqlConf);
    }

    function create()
    {
        Manager::getInstance()->register(CreateMysqlPool::getInstance(), 'quanduoduo');
    }

}