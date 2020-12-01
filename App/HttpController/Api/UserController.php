<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Admin\OneJoke;
use App\HttpModels\Admin\OneSaid;
use App\HttpModels\Api\LinkClick;
use App\HttpService\Common\CreateMysqlTable;

class UserController extends Index
{
    function clickLink()
    {
        $linkId = $this->getRawData('linkId');

        if (empty($linkId) || !is_numeric($linkId)) return $this->writeJson(201,null,null,'id错误');

        try
        {
            LinkClick::create()->data([
                'linkId'=>$linkId
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

            //$res = OneSaid::create()->where('id',date('Ymd')%$total)->get();
            $res = OneSaid::create()->where('id',mt_rand(1,$total))->get();

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

            //$res = OneJoke::create()->where('id',date('Ymd')%$total)->get();
            $res = OneJoke::create()->where('id',mt_rand(1,$total))->get();

        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,null,$res);
    }







}