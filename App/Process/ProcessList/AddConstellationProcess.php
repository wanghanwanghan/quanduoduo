<?php

namespace App\Process\ProcessList;

use App\HttpModels\Admin\Constellation;
use App\HttpService\CoHttpClient;
use App\HttpService\LogService;
use App\Process\ProcessBase;
use Carbon\Carbon;
use Swoole\Process;
use wanghanwanghan\someUtils\moudles\resp\create;

class AddConstellationProcess extends ProcessBase
{
    public $constellation;

    protected function run($arg)
    {
        //可以用来初始化
        parent::run($arg);

        //接收参数可以是字符串也可以是数组

        $this->constellation = [
            '水瓶座','双鱼座','白羊座','金牛座','双子座','巨蟹座','狮子座','处女座','天秤座','天蝎座','射手座','摩羯座'
        ];

        $this->addConstellation();
    }

    protected function addConstellation()
    {
        $startOfDay = Carbon::now()->startOfDay()->timestamp;
        $endOfDay = Carbon::now()->endOfDay()->timestamp;
        $startOfYear = Carbon::now()->startOfYear()->timestamp;
        $endOfYear = Carbon::now()->endOfYear()->timestamp;
        $weekOfYear = Carbon::now()->weekOfYear;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        while (true)
        {
            //today
            foreach ($this->constellation as $one)
            {
                $today = Constellation::create()->addSuffix('Today')
                    ->where('name',$one)
                    ->where('created_at',[$startOfDay,$endOfDay],'between')
                    ->get();

                if (!empty($today)) continue;

                $res = $this->getConstellationData($one,'today');

                if (empty($res)) continue;

                Constellation::create()->addSuffix('Today')->data([
                    'name' => $one,
                    'friend' => $res['QFriend'],
                    'color' => $res['color'],
                    'health' => $res['health'],
                    'love' => $res['love'],
                    'work' => $res['work'],
                    'money' => $res['money'],
                    'number' => $res['number'],
                    'summary' => $res['summary'],
                    'all' => $res['all'],
                ])->save();
            }

            //week
            foreach ($this->constellation as $one)
            {
                $week = Constellation::create()->addSuffix('Week')
                    ->where('name',$one)
                    ->where('week',$weekOfYear)
                    ->where('created_at',[$startOfYear,$endOfYear],'between')
                    ->get();

                if (!empty($week)) continue;

                $res = $this->getConstellationData($one,'week');

                if (empty($res)) continue;

                Constellation::create()->addSuffix('Week')->data([
                    'name' => $one,
                    'week' => $res['weekth'],
                    'health' => $res['health'],
                    'job' => $res['job'],
                    'love' => $res['love'],
                    'money' => $res['money'],
                    'work' => $res['work'],
                ])->save();
            }

            //month
            foreach ($this->constellation as $one)
            {
                $months = Constellation::create()->addSuffix('Month')
                    ->where('name',$one)
                    ->where('month',$month)
                    ->where('created_at',[$startOfYear,$endOfYear],'between')
                    ->get();

                if (!empty($months)) continue;

                $res = $this->getConstellationData($one,'month');

                if (empty($res)) continue;

                Constellation::create()->addSuffix('Month')->data([
                    'name' => $one,
                    'month' => $res['month'],
                    'all' => $res['all'],
                    'health' => $res['health'],
                    'love' => $res['love'],
                    'money' => $res['money'],
                    'work' => $res['work'],
                    'happyMagic' => $res['happyMagic'],
                ])->save();
            }

            //year
            foreach ($this->constellation as $one)
            {
                $years = Constellation::create()->addSuffix('Year')
                    ->where('name',$one)
                    ->where('year',$year)
                    ->get();

                if (!empty($years)) continue;

                $res = $this->getConstellationData($one,'year');

                if (empty($res)) continue;

                Constellation::create()->addSuffix('Year')->data([
                    'name' => $one,
                    'year' => $res['year'],
                    'allTitle' => $res['mima']['info'],
                    'allDesc' => current($res['mima']['text']),
                    'career' => current($res['career']),
                    'health' => current($res['health']),
                    'love' => current($res['love']),
                    'finance' => current($res['finance']),
                    'stone' => $res['luckeyStone'],
                ])->save();
            }

            \co::sleep(3600);
        }
    }

    protected function getConstellationData($constellation,$type)
    {
        $url = 'http://web.juhe.cn:8080/constellation/getAll';

        $postData = [
            'consName' => $constellation,
            'type' => $type,
            'key' => 'c44c1e062669e932d00599b23bc9a9d1',
        ];

        $res = (new CoHttpClient())->setDecode(true)->send($url,$postData);

        return (isset($res['resultcode']) && (int)$res['resultcode'] === 200) ? $res : [];
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
