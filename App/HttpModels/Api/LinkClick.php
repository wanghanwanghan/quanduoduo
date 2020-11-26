<?php

namespace App\HttpModels\Api;

use App\HttpModels\ModelsBase;

class LinkClick extends ModelsBase
{
    protected $tableName = 'admin_link_click';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}