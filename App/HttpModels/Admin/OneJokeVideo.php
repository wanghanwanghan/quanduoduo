<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class OneJokeVideo extends ModelsBase
{
    protected $tableName = 'oneJokeVideo';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}