<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class LabelInfo extends ModelsBase
{
    protected $tableName = 'admin_label_info';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}