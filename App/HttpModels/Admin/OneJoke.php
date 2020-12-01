<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class OneJoke extends ModelsBase
{
    protected $tableName = 'oneJoke';
    protected $autoTimeStamp = false;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}