<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpService\LogService;

class UserController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function login()
    {
        $username = $this->request()->getRequestParam('username') ?? '';
        $password = $this->request()->getRequestParam('password') ?? '';

        LogService::getInstance()->log4PHP($this->request()->getBody()->__toString());

        if ($username !== 'admin' || $password !== 'admin')
        {
            return $this->writeJson(201,null,null,'登陆失败');
        }

        return $this->writeJson(200,null,null,'登陆成功');
    }




}