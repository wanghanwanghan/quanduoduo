<?php

namespace App\HttpService;

class ServiceBase
{
    function __construct()
    {
        $this->onServiceCreate();
    }

    private function onServiceCreate()
    {

    }
}