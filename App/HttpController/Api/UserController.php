<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpService\Common\CreateMysqlTable;

class UserController extends Index
{
    function hkf()
    {
        $this->writeJson(200,null,null,'胡大胖是坑坑');
    }

    function login()
    {
        CreateMysqlTable::getInstance()->api_user();
    }
}