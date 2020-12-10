<?php

namespace App\Process\ProcessList;

use App\HttpModels\Admin\OneJoke;
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
        $H = '';

        while (true)
        {
            $nowH = (int)Carbon::now()->format('H');

            if ($H !== $nowH)
            {
                $H = $nowH;

                LogService::getInstance()->log4PHP([
                    'processNum' => __CLASS__,
                    'execTime' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                for ($page=1;$page<=4;$page++)
                {
                    $url = 'http://v.juhe.cn/joke/randJoke.php?key=41b914ce994bc0e57d0fce86b0041a03';

                    $res = (new CoHttpClient())->setDecode(true)->send($url,[],[],[],'get');

                    if (strtolower($res['reason']) === 'success' && !empty($res['result']) && $res['error_code'] === 0)
                    {
                        foreach ($res['result'] as $oneJoke)
                        {
                            $info = OneJoke::create()->where('md5Index',$oneJoke['hashId'])->get();

                            if (empty($info))
                            {
                                OneJoke::create()->data([
                                    'md5Index' => $oneJoke['hashId'],
                                    'oneJoke' => $oneJoke['content'],
                                    'unixTime' => $oneJoke['unixtime'],
                                    'created_at' => date('Y-m-d H:i:s',$oneJoke['unixtime']),
                                    'updated_at' => date('Y-m-d H:i:s',$oneJoke['unixtime']),
                                ])->save();
                            }
                        }
                    }
                }

            }else
            {
                \co::sleep(300);
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
