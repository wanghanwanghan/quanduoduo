<?php

namespace App\HttpService;

use EasySwoole\Component\Singleton;

class WxService extends ServiceBase
{
    use Singleton;

    function getOpenIdByJsCode($jsCode)
    {
        $data = [
            'appid' => 'wxe21bdc5cc38380b8',
            'secret' => '8e662390d62ce9edfa687dcfa2d71f26',
            'js_code' => $jsCode,
            'grant_type' => 'authorization_code',
        ];

        $url = 'https://api.weixin.qq.com/sns/jscode2session?' . http_build_query($data);

        return (new CoHttpClient())->setDecode(true)->send($url, $data, [], [], 'get');
    }

    function getAccessToken()
    {
        $data = [
            'appid' => 'wxe21bdc5cc38380b8',
            'secret' => '8e662390d62ce9edfa687dcfa2d71f26',
            'grant_type' => 'client_credential',
        ];

        $url = 'https://api.weixin.qq.com/cgi-bin/token?' . http_build_query($data);

        return (new CoHttpClient())->setDecode(true)->send($url, $data, [], [], 'get');
    }

    function decodePhone($encryptedData, $sessionKey, $iv): array
    {
        $aesKey = base64_decode($sessionKey);

        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt($aesCipher, 'AES-128-CBC', $aesKey, 1, $aesIV);

        $data = jsonDecode($result);

        LogService::getInstance()->log4PHP([
            'aesKey' => $aesKey,
            'aesIV' => $aesIV,
            'aesCipher' => $aesCipher,
            'result' => $result,
            'data' => $data,
        ]);

        return $data;
    }


}