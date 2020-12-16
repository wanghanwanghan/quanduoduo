<?php

namespace App\Process\ProcessList;

use App\HttpModels\Admin\HistoryOfToday;
use App\HttpService\CoHttpClient;
use App\HttpService\LogService;
use App\Process\ProcessBase;
use Carbon\Carbon;
use Swoole\Process;

class AddHistoryOfTodayProcess extends ProcessBase
{
    protected function run($arg)
    {
        //可以用来初始化
        parent::run($arg);

        //接收参数可以是字符串也可以是数组

        $this->addHistoryOfToday();
    }

    protected function addHistoryOfToday()
    {
        $listUrl = 'http://v.juhe.cn/todayOnhistory/queryEvent.php';
        $listKey = 'aeb05d404eec0a0d9253e4772054d9';
        $detailUrl = 'http://v.juhe.cn/todayOnhistory/queryDetail.php';
        $detailKey = '90aeb05d404eec0a0d9253e4772054d9';

        while (true)
        {
            $month = date('m') - 0;
            $day = date('d') - 0;

            $res = (new CoHttpClient())->setDecode(true)->send($listUrl,['date'=>"{$month}/{$day}",'key'=>$listKey]);

            if (strtolower($res['reason']) === 'success' && !empty($res['result']) && $res['error_code'] === 0)
            {
                foreach ($res['result'] as $oneHistory)
                {
                    $md5Index = md5(trim($oneHistory['e_id']).trim($oneHistory['title']));

                    $listInfo = HistoryOfToday::create()->where('md5Index',$md5Index)->get();

                    if (!empty($listInfo)) continue;

                    //取详情
                    $detailInfo = (new CoHttpClient())->setDecode(true)
                        ->send($detailUrl,['e_id'=>$oneHistory['e_id'],'key'=>$detailKey]);

                    if (strtolower($detailInfo['reason']) === 'success' && !empty($detailInfo['result']) && $detailInfo['error_code'] === 0)
                    {
                        $detail = jsonEncode(current($detailInfo['result']));
                    }else
                    {
                        $detail = '';
                    }

                    HistoryOfToday::create()->data([
                        'md5Index' => $md5Index,
                        'eventId' => $oneHistory['e_id'],
                        'title' => $oneHistory['title'],
                        'day' => Carbon::now()->format('m-d'),
                        'date' => $oneHistory['date'],
                        'detail' => $detail,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ])->save();
                }
            }

            \co::sleep(86400);
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
