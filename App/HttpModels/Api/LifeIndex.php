<?php

namespace App\HttpModels\Api;

use App\HttpModels\ModelsBase;

class LifeIndex extends ModelsBase
{
    protected $tableName = 'lifeIndex';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}