<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Admin\Constellation;
use App\HttpModels\Admin\HistoryOfToday;
use App\HttpModels\Admin\OneJoke;
use App\HttpModels\Admin\OneSaid;
use App\HttpModels\Api\GoodsClick;
use App\HttpModels\Api\LinkClick;
use App\HttpModels\Api\User;
use App\HttpService\WxService;
use Carbon\Carbon;
use wanghanwanghan\someUtils\control;

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

    function clickGoods()
    {
        $goodsId = $this->getRawData('goodsId');
        $openId = $this->getRawData('openId');

        if (empty($goodsId) || !is_numeric($goodsId)) return $this->writeJson(201,null,null,'id错误');

        try
        {
            $userInfo = User::create()->where('wxOpenId',$openId)->get();

            GoodsClick::create()->data([
                'goodsId'=>$goodsId,
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

    function getLifeIndex()
    {
        return $this->writeJson(200,null,null);
    }

    function getConstellation()
    {
        mt_srand();

        $constellation = $this->getRawData('constellation','');

        if (empty($constellation)) {
            $temp = ['水瓶座','双鱼座','白羊座','金牛座','双子座','巨蟹座','狮子座','处女座','天秤座','天蝎座','射手座','摩羯座'];
            $constellation = $temp[mt_rand(0,11)];
        }

        $type = strtolower($this->getRawData('type','today'));

        try
        {
            $res = Constellation::create()->addSuffix(ucfirst($type));

            switch ($type)
            {
                case 'today':
                    $startOfDay = Carbon::now()->startOfDay()->timestamp;
                    $endOfDay = Carbon::now()->endOfDay()->timestamp;
                    $res = $res->where('name',$constellation)
                        ->where('created_at',[$startOfDay,$endOfDay],'between')
                        ->get();
                    break;
                case 'week':
                    $startOfYear = Carbon::now()->startOfYear()->timestamp;
                    $endOfYear = Carbon::now()->endOfYear()->timestamp;
                    $week = Carbon::now()->weekOfYear;
                    $res = $res->where('name',$constellation)
                        ->where('week',$week)
                        ->where('created_at',[$startOfYear,$endOfYear],'between')
                        ->get();
                    break;
                case 'month':
                    $startOfYear = Carbon::now()->startOfYear()->timestamp;
                    $endOfYear = Carbon::now()->endOfYear()->timestamp;
                    $res = $res->where('name',$constellation)
                        ->where('month',Carbon::now()->month)
                        ->where('created_at',[$startOfYear,$endOfYear],'between')
                        ->get();
                    break;
                case 'year':
                    $res = $res->where('name',$constellation)
                        ->where('year',Carbon::now()->year)
                        ->get();
                    break;
            }

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$res);
    }

    function getHistoryOfToday()
    {
        mt_srand();

        try
        {
            $ids = HistoryOfToday::create()
                ->field('id')
                ->where('day',Carbon::now()->format('m-d'))
                ->all();

            empty($ids) ? $ids = [] : $ids = control::array_flatten(obj2Arr($ids));

            if (count($ids))
            {
                $index = mt_rand(0,count($ids) - 1);

                $res = HistoryOfToday::create()->where('id',$ids[$index])->get();

                $res['detail'] = preg_replace('/在\d+年前的今天[,|，]?/u','',$res['detail']);

            }else
            {
                $res = null;
            }

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

        $scInfo = WxService::getInstance()->decodePhone($encryptedData, $sessionKey, $iv);

        try
        {
            $info = User::create()->where('wxOpenId',$openId)->get();

            if (empty($info)) return $this->writeJson(201,null,null,'未找到用户');

            $info->update(['phone'=>$scInfo['purePhoneNumber'] ?? '']);

            $info = User::create()->where('wxOpenId',$openId)->get();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$info);
    }

    function edit()
    {
        $openId = $this->getRawData('openId');
        $remindTake = $this->getRawData('remindTake');

        $update = [
            'remindTake' => $remindTake,
        ];

        try
        {
            $info = User::create()->where('wxOpenId',$openId)->get();

            if (empty($info)) return $this->writeJson(201,null,null,'未找到用户');

            $info->update($update);

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,null,'修改成功');
    }




}