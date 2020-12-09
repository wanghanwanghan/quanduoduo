<?php

namespace App\Process\ProcessList;

use App\HttpService\CoHttpClient;
use App\HttpService\LogService;
use App\Process\ProcessBase;
use Carbon\Carbon;
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

        $H = '';

        while (true)
        {
            $nowH = (int)Carbon::now()->format('H');

            if ($H !== $nowH)
            {
                $H = $nowH;

                for ($page=1;$page<=4;$page++)
                {
                    $url = "http://v.juhe.cn/joke/content/text.php?page={$page}&pagesize=20&key=41b914ce994bc0e57d0fce86b0041a03";

                    $res = (new CoHttpClient())->setDecode(true)->send($url,[],[],[],'get');

                    LogService::getInstance()->log4PHP($res);
                }

            }else
            {
                \co::sleep(30);
            }
        }

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
