<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Admin\OneJoke;
use App\HttpModels\Admin\OneSaid;
use App\HttpModels\Api\LinkClick;
use App\HttpModels\Api\User;
use App\HttpService\CoHttpClient;
use App\HttpService\Common\CreateMysqlTable;
use App\HttpService\LogService;
use App\HttpService\WxService;

class UserController extends Index
{
    function clickLink()
    {
        $linkId = $this->getRawData('linkId');
        $openId = $this->getRawData('openId');

        if (empty($linkId) || !is_numeric($linkId)) return $this->writeJson(201,null,null,'id错误');

        try
        {
            $userInfo = User::create()->where('wxOpenId',$openId)->get();

            LinkClick::create()->data([
                'linkId'=>$linkId,
                'userId'=>empty($userInfo) ? 0 : $userInfo->id,
            ])->save();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson();
    }

    function getOneSaid()
    {
        mt_srand();

        try
        {
            $total = OneSaid::create()->count();

            $res = OneSaid::create()->where('id',mt_rand(0,$total) % $total)->get();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$res);
    }

    function getOneJoke()
    {
        mt_srand();

        try
        {
            $total = OneJoke::create()->count();

            $res = OneJoke::create()->where('id',mt_rand(0,$total) % $total)->get();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$res);
    }

    function login()
    {
        $username = $this->getRawData('username');
        $avatar = $this->getRawData('avatar');
        $jsCode = $this->getRawData('jsCode');

        if (empty($jsCode)) return $this->writeJson(201,null,null,'jsCode不能是空');

        $res = WxService::getInstance()->getOpenIdByJsCode($jsCode);

        $openId = is_array($res) ? $res['openid'] : $res->openid;

        $insert = [
            'username' => $username,
            'avatar' => $avatar,
            'wxOpenId' => $openId,
        ];

        try
        {
            $userInfo = User::create()->where('wxOpenId',$openId)->get();

            if (empty($userInfo))
            {
                User::create()->data($insert)->save();
            }else
            {
                $userInfo->update($insert);
            }

            $userInfo = User::create()->where('wxOpenId',$openId)->get();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$userInfo);
    }

    function bindPhone()
    {
        $jsCode = $this->getRawData('jsCode');
        $encryptedData = $this->getRawData('encryptedData');
        $iv = $this->getRawData('iv');

        $res = WxService::getInstance()->getOpenIdByJsCode($jsCode);

        $openId = is_array($res) ? $res['openid'] : $res->openid;
        $sessionKey = is_array($res) ? $res['session_key'] : $res->session_key;

        $info = WxService::getInstance()->decodePhone($encryptedData, $sessionKey, $iv);

        LogService::getInstance()->log4PHP($info);

        return $this->writeJson(200,null,$info,'胡大胖别生气了');
    }





}