<?php

namespace App\HttpController\Api;

use App\HttpController\Index;
use App\HttpService\Common\CreateMysqlTable;

class UserController extends Index
{
    function clickLink()
    {
        CreateMysqlTable::getInstance()->admin_link_click();
    }









}