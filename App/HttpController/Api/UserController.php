<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpModels\Api\User;
use App\HttpService\Common\CreateMysqlTable;

class UserController extends Index
{
    function hkf()
    {
        $this->writeJson(200,null,null,'胡大胖是坑坑');
    }

    function login()
    {
        try
        {
            User::create()->data([
                'phone' => 'wanghan123'
            ])->save();

        }catch (\Throwable $e)
        {
            $msg = $e->getMessage();
            $file = $e->getFile();
            $line = $e->getLine();

            $this->writeJson(200,$msg,$file,$line);
        }

        $this->writeJson(200,null,null,null);
    }
}