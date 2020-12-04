<?php

namespace App\HttpService;

use EasySwoole\Component\Singleton;

class WxService extends ServiceBase
{
    use Singleton;

    public $getOpenIdUrl = 'https://api.weixin.qq.com/sns/jscode2session';

    function getOpenIdByJsCode($jsCode)
    {
        $data = [
            'appid' => 'wxe21bdc5cc38380b8',
            'secret' => '8e662390d62ce9edfa687dcfa2d71f26',
            'js_code' => $jsCode,
            'grant_type' => 'authorization_code',
        ];

        $url = $this->getOpenIdUrl .= '?' . http_build_query($data);

        return (new CoHttpClient())->setDecode(true)->send($url, $data, [], [], 'get');
    }




}