<?php

namespace App\HttpModels\Api;

use App\HttpModels\ModelsBase;

class IpToLong extends ModelsBase
{
    protected $tableName = 'api_access_record';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}