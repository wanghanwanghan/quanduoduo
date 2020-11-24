<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class LinkInfo extends ModelsBase
{
    protected $tableName = 'admin_link_info';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}