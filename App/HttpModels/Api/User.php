<?php

namespace App\HttpModels\Api;

use App\HttpModels\ModelsBase;
use EasySwoole\ORM\AbstractModel;

class User extends AbstractModel
{
    protected $tableName = 'api_user';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}