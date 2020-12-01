<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class OneSaid extends ModelsBase
{
    protected $tableName = 'oneSaid';
    protected $autoTimeStamp = false;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}