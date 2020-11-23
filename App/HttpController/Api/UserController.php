<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpService\Common\CreateMysqlTable;

class UserController extends Index
{
    function wanghan()
    {
        $this->writeJson(200,null,null,'胡康飞是坑坑');
    }
}