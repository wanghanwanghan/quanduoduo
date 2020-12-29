<?php

namespace App\Process\ProcessList;

use App\HttpModels\Admin\OneJokeVideo;
use App\HttpService\LogService;
use App\Process\ProcessBase;
use Carbon\Carbon;
use QL\Ext\Chrome;
use QL\QueryList;
use Swoole\Process;

class AddJokeVideoProcess extends ProcessBase
{
    public $constellation;

    protected function run($arg)
    {
        //可以用来初始化
        parent::run($arg);

        //接收参数可以是字符串也可以是数组

        $this->addJokeVideo();
    }

    protected function addJokeVideo()
    {
        while (true)
        {
            for ($page = 1; $page <= 13; $page++)
            {
                $url = "https://www.qiushibaike.com/video/page/{$page}";

                $rules = [
                    'item' => ['video>source', 'src'],
                ];

                $ql = QueryList::getInstance();

                $ql->use(Chrome::class, 'chrome');

                $ql = $ql->chrome($url, ['args' => ['--no-sandbox']]);

                $res = $ql->rules($rules)->range('.old-style-col1>div')->query()->getData()->all();

                foreach ($res as $key => $one)
                {
                    $url = str_replace('//', 'https://', $one['item']);

                    if (empty($url)) continue;

                    $filename = explode('/', $url);
                    $filename = end($filename);

                    $check = OneJokeVideo::create()->where('url', "%{$filename}", 'like')->get();
                    if (!empty($check)) continue;

                    $ext = explode('.', $filename);
                    $ext = '.' . end($ext);

                    $year = date('Y');
                    $month = date('m');
                    $day = date('d');

                    $pathSuffix = $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day . DIRECTORY_SEPARATOR;

                    //传绝对路径
                    is_dir(FILE_PATH . $pathSuffix) ?: mkdir(FILE_PATH . $pathSuffix, 0644);

                    file_put_contents(FILE_PATH . $pathSuffix . $filename, file_get_contents($url));

                    OneJokeVideo::create()->data([
                        'url' => $pathSuffix . $filename,
                        'source' => '糗事百科',
                    ])->save();
                }
            }

            $time = mt_rand(21600, 86400);
            LogService::getInstance()->log4PHP(__FUNCTION__ . ' next at ' . Carbon::now()->addSeconds($time)->format('Y-m-d H:i:s'));
            \co::sleep($time);
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
