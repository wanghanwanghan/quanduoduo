<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpService\Common\CreateMysqlTable;

class UserController extends Index
{
    function wanghan()
    {
        CreateMysqlTable::getInstance()->api_user();
    }
}