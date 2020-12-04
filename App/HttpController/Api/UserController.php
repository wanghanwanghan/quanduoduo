<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Admin\OneJoke;
use App\HttpModels\Admin\OneSaid;
use App\HttpModels\Api\LinkClick;
use App\HttpModels\Api\User;
use App\HttpService\Common\CreateMysqlTable;

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
        try
        {
            $total = OneSaid::create()->count();

            $res = OneSaid::create()->where('id',substr(date('YmdHis'),0,-1)%$total)->get();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$res);
    }

    function getOneJoke()
    {
        try
        {
            $total = OneJoke::create()->count();

            $res = OneJoke::create()->where('id',substr(date('YmdHis'),0,-1)%$total)->get();

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
        $openId = $this->getRawData('openId');

        if (empty($openId)) return $this->writeJson(201,null,null,'openId错误');

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






}