<?php

namespace App\HttpService;

use App\HttpModels\Api\IpToLong;
use Carbon\Carbon;
use EasySwoole\Component\Singleton;
use EasySwoole\Http\Request;
use EasySwoole\RedisPool\Redis;

class StatisticsService extends ServiceBase
{
    use Singleton;

    //记录ip，访问量很大的ip不让访问
    function recordIp(Request $request)
    {
        isset($request->getHeader('x-real-ip')[0]) ? $realIp = $request->getHeader('x-real-ip')[0] : $realIp = null;

        $realIp = ip2long($realIp);

        if (!is_numeric($realIp)) return false;

        //存redis
        $redis = Redis::defer('redis');
        $redis->select(0);
        $key = 'access_record_'.Carbon::now()->format('Y_m_d_H_i');
        $redis->hIncrBy($key,$realIp,1);

        $num = $redis->hGet($key,$realIp);

        if ($num > 60) return false;

        $redis->expire($key,3600);

        //再记录ip
        try
        {
            IpToLong::create()->data([
                'ip2long' => $realIp,
                'ip' => $request->getHeader('x-real-ip')[0],
            ])->save();

        }catch (\Throwable $e)
        {
            return false;
        }

        return true;
    }


}