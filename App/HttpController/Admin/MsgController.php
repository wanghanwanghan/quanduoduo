<?php

namespace App\HttpController\Admin;

use App\HttpController\Index;

class MsgController extends Index
{
    function onRequest(?string $action): ?bool
    {
        return true;
    }

    function push()
    {

















        return $this->writeJson(200,null,null);
    }




}