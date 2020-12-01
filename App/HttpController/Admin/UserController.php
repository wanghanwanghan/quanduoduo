<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;

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

        if ($username !== 'admin' && $password !== 'admin')
        {
            return $this->writeJson(201,null,null,'登陆失败');
        }

        return $this->writeJson(200,null,null,'登陆成功');
    }




}