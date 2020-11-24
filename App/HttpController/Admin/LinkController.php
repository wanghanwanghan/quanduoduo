<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;
use App\HttpService\Common\CreateMysqlTable;

class LinkController extends Index
{
    function addTakeaway()
    {
        CreateMysqlTable::getInstance()->admin_link_info();
    }

    function addVegetable()
    {

    }

    function addSurprise()
    {

    }
}