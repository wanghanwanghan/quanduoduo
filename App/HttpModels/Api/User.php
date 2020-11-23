<?php

namespace App\HttpModels\Api;

use App\HttpModels\ModelsBase;

class User extends ModelsBase
{
    protected $tableName = 'api_user';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}