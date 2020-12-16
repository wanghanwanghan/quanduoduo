<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpModels\Api\User;

class UserController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function login()
    {
        $username = $this->getRawData('username');
        $password = $this->getRawData('password');

        if ($username !== 'admin' || $password !== 'admin')
        {
            return $this->writeJson(201,null,null,'登陆失败');
        }

        return $this->writeJson(200,null,null,'登陆成功');
    }

    function getMiniAppUserInfo()
    {
        $page = $this->getRawData('page',1);
        $pageSize = $this->getRawData('pageSize',10);

        try
        {
            $userInfo = User::create()->limit($this->exprOffset($page,$pageSize),$pageSize)->all();
            $total = User::create()->count();
        }catch (\Throwable $e)
        {
            return $this->writeErr($e,__FUNCTION__);
        }

        return $this->writeJson(200,$this->createPaging($page,$pageSize,$total),$userInfo,'成功');
    }




}