<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpService\CoHttpClient;
use App\HttpService\WxService;

class MsgController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function push()
    {
        $access_token = WxService::getInstance()->getAccessToken();
        $access_token = $access_token['access_token'];

        $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token={$access_token}";

        $data = [
            'touser' => 'oDCC45HOXc-CC6XyqVfAjyM_N-zQ',
            'template_id' => 'zyTie20yrJMNorCRpDv5v10NsBNnM0Qy2oZ6wvd4PU4',
            'page' => 'index',
            'data' => [
                'thing1' => ['value' => '胡大胖'],
                'thing2' => ['value' => '胡小胖'],
            ],
            'miniprogram_state' => 'developer',
            'lang' => 'zh_CN',
        ];

        $res = (new CoHttpClient())->setDecode(true)->send($url,$data);

        return $this->writeJson(200,null,$res);
    }




}