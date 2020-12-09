<?php

namespace App\Process\ProcessList;

use App\HttpService\LogService;
use App\Process\ProcessBase;
use Swoole\Process;

class AddJokeProcess extends ProcessBase
{
    protected function run($arg)
    {
        //可以用来初始化
        parent::run($arg);

        //接收参数可以是字符串也可以是数组

        $this->addJoke();
    }

    protected function addJoke()
    {
        //自定义进程不需要传参数，启动后就一直消费一个列队
    }

    protected function onPipeReadable(Process $process)
    {
        parent::onPipeReadable($process);

        return true;
    }

    protected function onShutDown()
    {
    }

    protected function onException(\Throwable $throwable, ...$args)
    {
        LogService::getInstance()->log4PHP($throwable->getMessage());
    }


}
