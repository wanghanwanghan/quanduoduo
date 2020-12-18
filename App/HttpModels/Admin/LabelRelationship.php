<?php

namespace App\HttpModels\Admin;

use App\HttpModels\ModelsBase;

class LabelRelationship extends ModelsBase
{
    protected $tableName = 'admin_label_relationship';
    protected $autoTimeStamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}